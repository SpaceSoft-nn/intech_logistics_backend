<?php

namespace App\Modules\IndividualPeople\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

final readonly class IndividualPeopleVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $first_name, //Из individual_people надо удалять эти свойства и оставлять только в Passport
        public string $last_name, //Из individual_people надо удалять эти свойства и оставлять только в Passport
        public string $father_name,//Из individual_people надо удалять эти свойства и pоставлять только в Passport

        public string $position,

        public ?string $other_contact,
        public ?string $comment,

        public ?string $phone,
        public ?string $email,

        public ?bool $remuved,

        public string $personal_area_id,

    ) { }



    public static function make(
        string $first_name,
        string $last_name,
        string $father_name,
        string $position,


        string $personal_area_id,
        ?string $passport_id = null,
        ?string $other_contact = null,
        ?string $comment = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $remuved = null,
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

    public static function fromArrayToObject(array $data)
    {
        return static::make(
            first_name: Arr::get($data, "first_name"),
            last_name: Arr::get($data, "last_name"),
            father_name: Arr::get($data, "father_name"),
            position: Arr::get($data, "position"),

            email: Arr::get($data, "email"),
            remuved: Arr::get($data, "remuved"),
            personal_area_id: Arr::get($data, "personal_area_id"),
            other_contact: Arr::get($data, "other_contact", null),
            comment: Arr::get($data, "comment" , null),
            phone: Arr::get($data, "phone", null),
        );
    }
}
