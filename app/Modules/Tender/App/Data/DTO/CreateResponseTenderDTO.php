<?php

namespace App\Modules\Tender\App\Data\DTO;

use Arr;

final readonly class CreateResponseTenderDTO
{

    public function __construct(

        public string $transport_id,
        public string $lot_tender_respons_id,
        public float $price_for_km,
        public ?string $organizaion_id,
        public ?string $comment,

    ) { }

    public function setOrganizationId(string $organizaion_id) : self
    {
        return self::make(
            transport_id: $this->transport_id,
            lot_tender_respons_id: $this->lot_tender_respons_id,
            price_for_km: $this->price_for_km,
            organizaion_id: $organizaion_id,
            comment: $this->comment,
        );
    }


    public static function make(

        string $transport_id,
        string $lot_tender_respons_id,
        string $price_for_km,
        ?string $organizaion_id,
        ?string $comment = null,

    ) : self {

        return new self(
            transport_id: $transport_id,
            lot_tender_respons_id: $lot_tender_respons_id,
            price_for_km: $price_for_km,
            organizaion_id: $organizaion_id,
            comment: $comment,
        );

    }

    public static function fromArrayToObject(array $data): self
    {
        return self::make(
            transport_id: Arr::get($data, 'transport_id'),
            lot_tender_respons_id: Arr::get($data, 'lot_tender_respons_id'),
            price_for_km: Arr::get($data, 'price_for_km'),
            organizaion_id: Arr::get($data, 'organizaion_id'),
            comment: Arr::get($data, 'comment'),
        );
    }


}
