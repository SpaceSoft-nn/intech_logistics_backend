<?php

namespace App\Modules\IndividualPeople\App\Data\ValueObject;

use Arr;
use Illuminate\Contracts\Support\Arrayable;

use App\Modules\Base\Traits\FilterArrayTrait;

final readonly class DriverPeopleVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $personal_area_id,
        public ?string $organization_id,

        public string $series,
        public string $number,
        public string $date_get,


    ) { }

    public static function make(

        string $personal_area_id,

        string $series,
        string $number,
        string $date_get,

        ?string $organization_id = null,

    ) : self {


        return new self(

            personal_area_id: $personal_area_id,

            series: $series,
            number: $number,
            date_get: $date_get,

            organization_id: $organization_id,

        );

    }



    public function toArray() : array
    {
        return [
            'personal_area_id' => $this->personal_area_id,
            'organization_id' => $this->organization_id,
            "series" => $this->series,
            "number" => $this->number,
            "date_get" => $this->date_get,
        ];
    }

    public static function fromArrayToObject(array $data)
    {
        return static::make(
            personal_area_id: Arr::get($data, "personal_area_id"),
            series: Arr::get($data, "series"),
            number: Arr::get($data, "number"),
            date_get: Arr::get($data, "date_get"),
            organization_id: Arr::get($data, "organization_id", null),
        );
    }
}
