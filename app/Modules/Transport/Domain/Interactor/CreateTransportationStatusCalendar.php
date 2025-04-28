<?php

namespace App\Modules\Transport\Domain\Interactor;

use DB;
use Illuminate\Support\Collection;
use App\Modules\Base\Error\BusinessException;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;

use function App\Helpers\isNullToBusinessException;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\App\Data\Enums\TransportationStatusEnum;
use App\Modules\Transport\Domain\Models\TransportationStatusСalendar;
use App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus;
use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportationStatusСalendarVO;
use App\Modules\Transport\App\Repositories\TransportationStatusKalendarReposiroty;
use App\Modules\Transport\Domain\Actions\TransportCalendar\TransportationStatusСalendarAction;

class CreateTransportationStatusCalendar
{

    public function __construct(
        private OrderUnitRepository $rep,
        private TransportationStatusKalendarReposiroty $transportationStatusKalendarReposiroty,
    ) {}

    /**
     * @param string $email
     *
     * @return Collection<TransportationStatusСalendar>
     */
    public function execute(string $email) : Collection
    {
        return $this->run($email);
    }

    /**
     * @param string $order_unit_id
     *
     * @return Collection<TransportationStatusСalendar>
     */
    private function run(string $order_unit_id) : Collection
    {

        /**
         * @var Collection
         */
        $array = DB::transaction(function () use ($order_unit_id) {

            /**
             * @var OrderUnit
             */
            $orderUnit = $this->getOrderUnit($order_unit_id);

            //Проверка доступов
            $this->checkPermission($orderUnit);

            $i = 0;
            //делаем цепочку статусов
            foreach ($orderUnit->addresses as $address) {
                $chains[$i]['type'] = $address->pivot->type;
                $chains[$i]['date'] = $address->pivot->data_time;
                $i++;
            }

            //проверяем есть ли цепочка у order - если нету создаём её
            if ($this->isNullTransportationStatusEvent($orderUnit)) {

                $chainsNew = [];

                foreach ($chains as $chain) {

                    /**
                     * @var TransportationStatusEnum
                    */
                    $enumStatus = TypeStateAddressEnum::objectAddressEnumToEnumTransportationStatus($chain['type']);

                    /** @var TransportationStatusСalendar */
                    $chainsNew[] = $this->createTransporationStatusEvent(
                        order: $orderUnit,
                        enum: $enumStatus,
                        date: $chain['date'],
                    );

                }

                return collect($chainsNew);

            } else {

                /** @var */
                $collect = $this->transportationStatusKalendarReposiroty->findForOrderAndTransport($orderUnit->id, $orderUnit->transport->id);

                return $collect->toBase();

            }

        });

        return $array;
    }

    private function getOrderUnit(string $order_unit_id): OrderUnit
    {
        $order = $this->rep->get($order_unit_id);

        isNullToBusinessException($order, "Заказ по данному индефикатору не найден.", 404);

        return $order;
    }

    /**
     * Проверяем - пустая ли табличка по заданному order
     * @param OrderUnit $order
     *
     * @return bool
     */
    private function isNullTransportationStatusEvent(OrderUnit $order): bool
    {
        return TransportationStatusСalendar::where('order_unit_id', $order->id)->where('transport_id', $order->transport->id)->get()->count() == 0 ? true : false;
    }

    private function createTransporationStatusEvent(OrderUnit $order, TransportationStatusEnum $enum, string $date): TransportationStatusСalendar
    {

        $enumTransportationStatus = $this->getFindEnum($enum);

        return TransportationStatusСalendarAction::make(
            TransportationStatusСalendarVO::make(
                order_unit_id: $order->id,
                date: $date,
                enum_transportation_id: $enumTransportationStatus->id,
                transport_id: $order->transport->id,
            )
        );
    }

    private function getFindEnum(TransportationStatusEnum $enum): EnumTransportationStatus
    {
        $enumTransportationStatus = EnumTransportationStatus::where('enum_name', $enum->getNameCase())->first();

        return $enumTransportationStatus;
    }

    private function checkPermission(OrderUnit $orderUnit) : bool
    {
        $statusTransport = $orderUnit->transport;

        if(is_null($statusTransport)) { throw new BusinessException('У данного водителя, нету активных заказов.'); }

        return true;
    }

}
