<?php

namespace App\Modules\Tender\App\Repositories;

use App\Modules\Base\Repositories\CoreRepository;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\Tender\Domain\Models\LotTender as Model;
use App\Modules\Tender\Domain\Actions\LotTender\CreateLotTenderAction;
use App\Modules\Tender\Domain\Actions\LotTender\TenderAndContractorFilterAction;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors\TendersAndContractorFilterAction;
use Illuminate\Database\Eloquent\Collection;

class TenderRepositories extends CoreRepository
{
    protected function getModelClass()
    {
        return Model::class;
    }

    private function query() : \Illuminate\Database\Eloquent\Builder
    {
        return $this->startConditions()->query();
    }


    public function save(LotTenderVO $vo) : Model
    {
        return CreateLotTenderAction::make($vo);
    }

    public function getById($uuid) : ?Model
    {
        return $this->query()->find($uuid);
    }

      /**
     * Вернуть все тендеры и указать по дополнительному полю в атрибутах model - откликался ли перевозчик "contractor" на этот заказ.
     * @param string $organization
     *
     * @return Collection
     */
    public function getTendersFilterByContractor(string $organization_id) : Collection
    {
        return TendersAndContractorFilterAction::execute($organization_id);
    }

    /**
     * Вернуть один тендер по uuid и указать по дополнительному полю в атрибутах model - откликался ли перевозчик "contractor" на этот заказ.
     * @param string $organization
     *
     * @return ?Model
    */
    public function getTenderFilterByContractor(string $organization_id, string $order_id) : ?Model
    {
        return TenderAndContractorFilterAction::execute($organization_id, $order_id);
    }

}
