<?php

namespace App\Modules\Tender\App\Data\DTO;

use Arr;

final readonly class CreateResponseTenderDTO
{

    public function __construct(

        public string $transport_id,
        public float $price_for_km,
        public ?string $lot_tender_id,
        public ?string $organizaion_id,
        public ?string $comment,

    ) { }

    public function setOrganizationId(string $organizaion_id) : self
    {
        return self::make(
            transport_id: $this->transport_id,
            price_for_km: $this->price_for_km,
            lot_tender_id: $this->lot_tender_id,
            organizaion_id: $organizaion_id,
            comment: $this->comment,
        );
    }

    public function setLotTenderId(string $lot_tender_id) : self
    {
        return self::make(
            transport_id: $this->transport_id,
            price_for_km: $this->price_for_km,
            lot_tender_id: $lot_tender_id,
            organizaion_id: $this->organizaion_id,
            comment: $this->comment,
        );
    }


    public static function make(

        string $transport_id,
        string $price_for_km,
        ?string $lot_tender_id,
        ?string $organizaion_id,
        ?string $comment = null,

    ) : self {

        return new self(
            transport_id: $transport_id,
            price_for_km: $price_for_km,
            lot_tender_id: $lot_tender_id,
            organizaion_id: $organizaion_id,
            comment: $comment,
        );

    }

    public static function fromArrayToObject(array $data): self
    {
        return self::make(
            transport_id: Arr::get($data, 'transport_id'),
            price_for_km: Arr::get($data, 'price_for_km'),
            lot_tender_id: Arr::get($data, 'lot_tender_id', null),
            organizaion_id: Arr::get($data, 'organizaion_id', null),
            comment: Arr::get($data, 'comment', null),
        );
    }


}
