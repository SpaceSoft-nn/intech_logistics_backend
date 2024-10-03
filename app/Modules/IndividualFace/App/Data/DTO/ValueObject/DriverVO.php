<?php

namespace App\Modules\IndividualFace\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class DriverVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $personal_area_id,
        public readonly string $individual_people_id,
        public ?string $organization_id,
    ) {}

    public static function make(
        string $personal_area_id,
        string $individual_people_id,
        ?string $organization_id = null,
    ) : self {
        return new self(
            personal_area_id: $personal_area_id,
            individual_people_id: $individual_people_id,
            organization_id: $organization_id,
        );
    }

    public function toArray() : array
    {
        return [
            "personal_area_id" => $this->personal_area_id,
            "individual_people_id" => $this->individual_people_id,
            "organization_id" => $this->organization_id,
        ];
    }

}
