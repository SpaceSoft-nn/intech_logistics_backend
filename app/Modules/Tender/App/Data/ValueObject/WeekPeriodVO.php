<?php

namespace App\Modules\Tender\App\Data\ValueObject;

use App\Modules\Base\Enums\WeekEnum;
use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

final readonly class WeekPeriodVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $lot_tender_id,
        public WeekEnum $value,
    ) {}


    public static function make(

        string $lot_tender_id,
        string|WeekEnum $value,

    ) : self {

        //если пришёл string, переводим в enum
        if($value instanceof string)
        {
            $value = WeekEnum::stringByCaseToObject($value);
        }

        return new self(
            lot_tender_id: $lot_tender_id,
            value: $value,
        );

    }


    public function toArray() : array
    {
        return [
            "lot_tender_id" => $this->lot_tender_id,
            "value" => $this->value,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            lot_tender_id: Arr::get($data, 'lot_tender_id'),
            value: Arr::get($data, 'value'),
        );

    }

}
