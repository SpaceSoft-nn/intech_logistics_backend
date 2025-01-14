<?php

namespace App\Modules\Tender\App\Data\ValueObject\Response;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;
use Arr;

final readonly class AgreementTenderVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $lot_tender_response_id,
        public string $organization_contractor_id, // органиация заказчика, которая создала тендер
        public string $lot_tender_id,
    ) {}


    public static function make(

        string $lot_tender_response_id,
        string $organization_contractor_id,
        string $lot_tender_id,

    ) : self {

        return new self(
            lot_tender_response_id: $lot_tender_response_id,
            organization_contractor_id: $organization_contractor_id,
            lot_tender_id: $lot_tender_id,
        );

    }


    public function toArray() : array
    {
        return [
            "lot_tender_response_id" => $this->lot_tender_response_id,
            "organization_contractor_id" => $this->organization_contractor_id,
            "lot_tender_id" => $this->lot_tender_id,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            lot_tender_response_id: Arr::get($data, 'lot_tender_response_id'),
            organization_contractor_id: Arr::get($data, 'organization_contractor_id'),
            lot_tender_id: Arr::get($data, 'lot_tender_id'),
        );

    }

}
