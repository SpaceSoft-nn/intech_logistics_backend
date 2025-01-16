<?php

namespace App\Modules\IndividualPeople\App\Data\DTO;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;

class CreateStorekeeperPeopleDTO
{

    use FilterArrayTrait;

    public function __construct(

        public StorekeeperPeopleVO $vo,
        public string $individual_people_id,

    ) { }

    public static function make(

        StorekeeperPeopleVO $vo,
        string $individual_people_id,

    ) : self {

        return new self(

            vo: $vo,
            individual_people_id: $individual_people_id,

        );
    }

}
