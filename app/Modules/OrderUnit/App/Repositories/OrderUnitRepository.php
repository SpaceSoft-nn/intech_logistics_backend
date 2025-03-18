<?php

namespace App\Modules\OrderUnit\App\Repositories;

use function App\Helpers\Mylog;
use Illuminate\Database\Eloquent\Collection;
use App\Modules\Address\Domain\Models\Address;
use App\Modules\Base\Repositories\CoreRepository;
use Illuminate\Support\Collection as SupportCollection;
use App\Modules\OrderUnit\Domain\Models\OrderUnitStatus;
use App\Modules\OrderUnit\Domain\Models\OrderUnit as Model;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus\OrderUnitStatusCreateAction;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors\OrderAndContractorFilterAction;

use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors\OrdersAndContractorFilterAction;

class OrderUnitRepository extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }

    public function get(string $uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }

    /**
     * @param string[] $uuid
     * @return ?Model[]
     */
    public function getAll(array $arrUuid) : ?Collection
    {
        return $this->query()->find($arrUuid);
    }

    /**
     * Получаем последний адресс (прибытия) по приоритетности при связи orderUnit => Address
     * @param Model|int $order
     * @return ?Address
     */
    public function lastPivotPriorityAddress(Model|int $order) : ?Address
    {

        if ($order instanceof Model) {

            $maxPriority = $order->addresses()->max('priority');

            $lastAddress = $order->addresses()
            ->wherePivot('priority', $maxPriority)
            ->first();

        } else {

            $order = $this->query()->find($order);

            $maxPriority = $order->addresses()->max('priority');

            $lastAddress = $order->addresses()
            ->wherePivot('priority', $maxPriority)
            ->first();
        }



        return $lastAddress;
    }

    /**
     * Получаем первый адресс (отправки) по приоритетности при связи orderUnit => Address
     * @param Model|int $order
     * @return ?Address
     */
    public function firstPivotPriorityAddress(Model|int $order) : ?Address
    {
        if($order instanceof Model){

            $minPriority = $order->addresses()->min('priority');

            $firstAddress = $order->addresses()
                                    ->wherePivot('priority', $minPriority)
                                    ->first();

        } else {

            $order = $this->query()->find($order);

            if(!$order) { return null; }

            $minPriority = $order->addresses()->min('priority');

            $firstAddress = $order->addresses()
            ->wherePivot('priority', $minPriority)
            ->first();

        }

        return $firstAddress;
    }

    /**
     * Получить cargo_units через CargoGood
     * @param Model $model
     *
     * @return SupportCollection
     */
    public function cargo_units(Model $model) : SupportCollection
    {
        return $model->cargo_goods()->with('cargo_units')->get()->pluck('cargo_units')->flatten()->unique('id');
    }

    /**
     * Устанавливаем статус для OrderUnit
     * @param StatusOrderUnitEnum $status
     * @param string $orderId
     *
     * @return OrderUnitStatus
     */
    public function setStatus(StatusOrderUnitEnum $status, string $orderId) : OrderUnitStatus
    {
        //Создание статуса
        return OrderUnitStatusCreateAction::make(
            OrderUnitStatusVO::make(
                order_unit_id: $orderId,
                status : $status->getNameCase(),
            )
        );
    }

    /**
     * Вернуть все заказы, которые принадлежат данному user
     * @param string $uuid
     *
     * @return Collection
     */
    public function getAllBelongsUser(string $uuid) : Collection
    {
        $array = $this->query()->where('user_id', $uuid)->get();

        return $array;
    }

    /**
     * Вернуть все заказы, которые принадлежат данной организации
     * @param string $uuid
     *
     * @return Collection
     */
    public function getAllBelongsOrganization(string $uuid) : Collection
    {
        return $this->query()->where('organization_id', $uuid)->get();
    }


    /**
     * #TODO Может быть баг, когда у нас может быть несколько заказов в работе у одного транспорта, нужно делать проверки, first -
     * вернёт последний, который может быть не актульный для данного вывода
     * Вернуть заказ по транспорту, который находится в работе
     * @param string $transport_id
     *
     * @return [type]
    */
    public function getOrderUnitAndStatusInWork(string $transport_id)
    {
        return $this->query()->where('transport_id', $transport_id)
            ->whereHas('actual_status', function ($query) {
                $query->where('status', StatusOrderUnitEnum::in_work);
            })->first();
    }


    /**
     * Вернуть все заказы и указать по дополнительному полю в атрибутах model - откликался ли перевозчик "contractor" на этот заказ.
     * @param string $organization
     * @param array $status
     *
     * @return Collection
     */
    public function getOrdersFilterByContractor(string $organization_id, array $status) : Collection
    {
        return OrdersAndContractorFilterAction::execute($organization_id, $status);
    }

    /**
     * Вернуть один заказ по uuid и указать по дополнительному полю в атрибутах model - откликался ли перевозчик "contractor" на этот заказ.
     * @param string $organization
     *
     * @return ?Model
    */
    public function getOrderFilterByContractor(string $organization_id, string $order_id) : ?Model
    {
        return OrderAndContractorFilterAction::execute($organization_id, $order_id);
    }
}
