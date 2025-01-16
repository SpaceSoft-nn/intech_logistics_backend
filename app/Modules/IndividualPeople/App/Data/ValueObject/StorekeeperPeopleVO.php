<?php

namespace App\Modules\IndividualPeople\App\Data\ValueObject;

use Arr;
use Illuminate\Contracts\Support\Arrayable;

use App\Modules\Base\Traits\FilterArrayTrait;

final readonly class StorekeeperPeopleVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $personal_area_id,
        public ?string $organization_id,

    ) { }

    public static function make(

        string $personal_area_id,
        ?string $organization_id = null,

    ) : self {


        return new self(

            personal_area_id: $personal_area_id,
            organization_id: $organization_id,

        );

    }

    public function toArray() : array
    {
        return [
            'personal_area_id' => $this->personal_area_id,
            'organization_id' => $this->organization_id,
        ];
    }

    public static function fromArrayToObject(array $data)
    {
        return static::make(
            personal_area_id: Arr::get($data, "personal_area_id"),
            organization_id: Arr::get($data, "organization_id", null),
        );
    }
}
