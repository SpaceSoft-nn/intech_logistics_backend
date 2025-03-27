<?php

namespace App\Modules\IndividualPeople\App\Data\ValueObject;

use Arr;
use Illuminate\Contracts\Support\Arrayable;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;

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

    public static function mappingForModel(DriverPeople $driverPeople) : self
    {

        return self::make(
            personal_area_id: $driverPeople->personal_area_id,
            series: $driverPeople->series,
            number: $driverPeople->number,
            date_get: $driverPeople->date_get,
            organization_id: $driverPeople->organization_id,
        );
    }

    //Делаем TransportVO под Обновления
    public static function mappingForUpdate(DriverPeople $driverPeople, array $data) : self
    {
        $driverPeopleVO = self::mappingForModel($driverPeople);

        $personal_area_id = $driverPeople->personal_area_id;
        $series = $driverPeople->series;
        $number = $driverPeople->number;
        $date_get = $driverPeople->date_get;
        $organization_id = $driverPeople->organization_id;

        $personal_area_id = Arr::get($data, "personal_area_id", $driverPeopleVO->personal_area_id);
        $series = Arr::get($data, "series", $driverPeopleVO->series);
        $number = Arr::get($data, "number", $driverPeopleVO->number);
        $date_get = Arr::get($data, "date_get", $driverPeopleVO->date_get);
        $organization_id = Arr::get($data, "organization_id", $driverPeopleVO->organization_id);


        return self::make(
            personal_area_id: $personal_area_id,
            series: $series,
            number: $number,
            date_get: $date_get,
            organization_id: $organization_id,
        );
    }
}
