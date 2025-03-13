<?php

namespace App\Modules\IndividualPeople\App\Data\DTO;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\IndividualPeopleVO;
use App\Modules\IndividualPeople\App\Data\ValueObject\PassportVO;


class CreateIndividualPeopleDTO extends BaseDTO
{

    use FilterArrayTrait;

    public function __construct(

        public IndividualPeopleVO $individualPeopleVO,
        public PassportVO $passportVO,

    ) { }

    public static function make(

        IndividualPeopleVO $individualPeopleVO,
        PassportVO $passportVO,

    ) : self {


        return new self(

            individualPeopleVO: $individualPeopleVO,
            passportVO: $passportVO,

        );

    }



}
