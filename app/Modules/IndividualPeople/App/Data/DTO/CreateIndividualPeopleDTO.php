<?php

namespace App\Modules\IndividualPeople\App\Data\DTO;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use Illuminate\Contracts\Support\Arrayable;

class CreateIndividualPeopleDTO extends BaseDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $father_name,

        public readonly string $position,

        public readonly string $other_contact,
        public readonly string $comment,

        public readonly ?string $phone,
        public readonly ?string $email,

        public readonly ?bool $remuved,

        public readonly int $personal_area_id,

    ) { }

    public static function make(
        string $first_name,
        string $last_name,
        string $father_name,
        string $position,
        string $other_contact,
        string $comment,
        string $personal_area_id,
        ?string $phone,
        ?string $email,
        ?string $remuved,
    ) : self {


        return new self(

            first_name: $first_name,
            last_name: $last_name,
            father_name: $father_name,

            position: $position,

            other_contact: $other_contact,
            comment: $comment,

            phone: $phone,
            email: $email,

            remuved: $remuved,

            personal_area_id: $personal_area_id,
        );

    }

    public function toArray() : array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' =>  $this->last_name,
            'father_name' => $this->father_name,

            'position' => $this->position,

            'other_contact' => $this->other_contact,
            'comment' => $this->comment,

            'phone' => $this->phone,
            'email' => $this->email,

            'remuved' => $this->remuved,

            'personal_area_id' => $this->personal_area_id,
        ];
    }

}
