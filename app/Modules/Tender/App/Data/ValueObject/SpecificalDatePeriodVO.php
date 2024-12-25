<?php

namespace App\Modules\Tender\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

final readonly class SpecificalDatePeriodVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $lot_tender_id,
        public string $date,
        public string $count_transport,
    ) {}


    public static function make(

        string $lot_tender_id,
        string $date,
        string $count_transport,

    ) : self {

        return new self(
            lot_tender_id: $lot_tender_id,
            date: $date,
            count_transport: $count_transport,
        );

    }


    public function toArray() : array
    {
        return [
            "lot_tender_id" => $this->lot_tender_id,
            "date" => $this->date,
            "count_transport" => $this->count_transport,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            lot_tender_id: Arr::get($data, 'lot_tender_id'),
            date: Arr::get($data, 'date'),
            count_transport: Arr::get($data, 'count_transport'),
        );

    }

}
