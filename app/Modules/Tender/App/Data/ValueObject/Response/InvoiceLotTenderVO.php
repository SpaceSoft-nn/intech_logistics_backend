<?php

namespace App\Modules\Tender\App\Data\ValueObject\Response;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;
use Arr;

final readonly class InvoiceLotTenderVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $transport_id,
        public string $lot_tender_response_id,
        public float $price_for_km,
        public ?string $comment,
    ) {}


    public static function make(

        string $transport_id,
        string $lot_tender_response_id,
        float $price_for_km,
        ?string $comment = null,

    ) : self {

        return new self(
            transport_id: $transport_id,
            lot_tender_response_id: $lot_tender_response_id,
            price_for_km: $price_for_km,
            comment: $comment,
        );

    }


    public function toArray() : array
    {
        return [
            "transport_id" => $this->transport_id,
            "lot_tender_response_id" => $this->lot_tender_response_id,
            "price_for_km" => $this->price_for_km,
            "comment" => $this->comment,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            transport_id: Arr::get($data, 'transport_id'),
            lot_tender_response_id: Arr::get($data, 'lot_tender_response_id'),
            price_for_km: Arr::get($data, 'price_for_km'),
            comment: Arr::get($data, 'comment'),
        );

    }

}
