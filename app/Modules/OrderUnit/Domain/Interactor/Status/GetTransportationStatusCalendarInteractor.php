<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Status;

use DB;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use function App\Helpers\isNullToBusinessException;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\App\Data\Enums\TransportationStatusEnum;
use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;
use App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus;
use App\Modules\OrderUnit\App\Repositories\TransportationStatusReposiroty;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\Status\TransporationStatusVO;

use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus\CreateTransporationStatusAction;

class GetTransportationStatusCalendarInteractor
{

    public function __construct(
        public OrderUnitRepository $rep,
        public TransportationStatusReposiroty $transportationStatusReposiroty,
    ) {}

    public function execute(string $order_unit_id) : ?TransporationStatus
    {
        return $this->run($order_unit_id);
    }

    private function run(string $order_unit_id) : ?TransporationStatus
    {

        /**
         * @var TransporationStatus
         */
        $transporationStatusEvent = DB::transaction(function () use ($order_unit_id) {

            /**
             * @var OrderUnit
             */
            $orderUnit = $this->getOrderUnit($order_unit_id);

            //делаем цепочку статусов
            foreach ($orderUnit->addresses as $address) {
                $chain[] = $address->pivot->type;
            }

            //проверяем есть ли цепочка у order - если нету создаём её
            if ($this->isNullTransportationStatusEvent($orderUnit)) {

                /**
                 * @var TransportationStatusEnum
                 */
                $enumStatus = TypeStateAddressEnum::objectAddressEnumToEnumTransportationStatus($chain[0]);

                /** @var TransporationStatus */
                $trEvent = $this->createTransporationStatusEvent(
                    order: $orderUnit,
                    enum: $enumStatus,
                );

                return $trEvent;

            } else {

                //возвращаем последнию созданную запись
                $last = $this->transportationStatusReposiroty->getLastRecord($orderUnit->id);

                //вернуть записи без статуса транзит
                $count = $this->transportationStatusReposiroty->getWithoutTransit($order_unit_id)->count();

                if ($this->checkingUploadongOrUnloading($last) && $count != count($chain) ) {

                    return $this->createTransporationStatusEvent($orderUnit, TransportationStatusEnum::transit);

                } else {

                    $count = $this->transportationStatusReposiroty->getWithoutTransit($order_unit_id)->count();

                    $chainCount = isset($chain[$count]) ? $chain[$count] : null;

                    if(is_null($chainCount)) { return; }

                    /**
                     * @var TransportationStatusEnum
                     */
                    $enumStatus = TypeStateAddressEnum::objectAddressEnumToEnumTransportationStatus($chainCount);

                    return $this->createTransporationStatusEvent(
                        order: $orderUnit,
                        enum: $enumStatus,
                    );
                }
            }

            return $transporationStatusEvent;
        });

        return $transporationStatusEvent;
    }

    private function getOrderUnit(string $order_unit_id): OrderUnit
    {
        $order = $this->rep->get($order_unit_id);

        isNullToBusinessException($order, "Заказ по данному индефикатору не найден.", 404);

        return $order;
    }

    private function checkingUploadongOrUnloading(TransporationStatus $last): bool
    {
        $actualStatus = $last->enum_transporatrion_status;

        return $actualStatus->enum_value == TransportationStatusEnum::loading || $actualStatus->enum_value == TransportationStatusEnum::unloading;
    }


    /**
     * Проверяем - пустая ли табличка по заданному order
     * @param OrderUnit $order
     *
     * @return bool
     */
    private function isNullTransportationStatusEvent(OrderUnit $order): bool
    {
        return TransporationStatus::where('order_unit_id', $order->id)->get()->count() == 0 ? true : false;
    }

    private function createTransporationStatusEvent(OrderUnit $order, TransportationStatusEnum $enum): TransporationStatus
    {

        $enumTransportationStatus = $this->getFindEnum($enum);

        return CreateTransporationStatusAction::make(
            TransporationStatusVO::make(
                order_unit_id: $order->id,
                enum_transporatrion_status_id: $enumTransportationStatus->id,
            )
        );
    }

    private function getFindEnum(TransportationStatusEnum $enum): EnumTransportationStatus
    {
        $enumTransportationStatus = EnumTransportationStatus::where('enum_name', $enum->getNameCase())->first();

        return $enumTransportationStatus;
    }
}
