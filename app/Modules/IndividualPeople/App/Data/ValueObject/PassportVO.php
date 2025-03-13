<?php

namespace App\Modules\IndividualPeople\App\Data\ValueObject;

use Arr;
use Illuminate\Contracts\Support\Arrayable;

use App\Modules\Base\Traits\FilterArrayTrait;

final readonly class PassportVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public string $first_name, //Из individual_people_id надо удалять эти свойства и оставлять только в Passport
        public string $last_name, //Из individual_people_id надо удалять эти свойства и оставлять только в Passport
        public string $father_name, //Из individual_people_id надо удалять эти свойства и оставлять только в Passport
        public string $passport_series,
        public string $passport_number,
        public string $issue_date,
        public string $issued_by,
        public ?string $department_code,
        public ?string $individual_people_id,


    ) { }

    public static function make(

        string $first_name,
        string $last_name,
        string $father_name,
        string $passport_series,
        string $passport_number,
        string $issue_date,
        string $issued_by,
        ?string $department_code = null,
        ?string $individual_people_id = null,


    ) : self {


        return new self(

            first_name: $first_name,
            last_name: $last_name,
            father_name: $father_name,
            passport_series: $passport_series,
            passport_number: $passport_number,
            issue_date: $issue_date,
            issued_by: $issued_by,
            department_code: $department_code,
            individual_people_id: $individual_people_id,

        );

    }

    public function setIndividualPeople(string $individualPeopleId) : self
    {

        return new self(

            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            passport_series: $this->passport_series,
            passport_number: $this->passport_number,
            issue_date: $this->issue_date,
            issued_by: $this->issued_by,
            department_code: $this->department_code,
            individual_people_id: $individualPeopleId,

        );

    }



    public function toArray() : array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'passport_series' => $this->passport_series,
            'passport_number' => $this->passport_number,
            'issue_date' => $this->issue_date,
            'issued_by' => $this->issued_by,
            'department_code' => $this->department_code,
            'individual_people_id' => $this->individual_people_id,
        ];
    }

    public static function fromArrayToObject(array $data)
    {
        return static::make(
            first_name: Arr::get($data, "first_name"),
            last_name: Arr::get($data, "last_name"),
            father_name: Arr::get($data, "father_name"),
            passport_series: Arr::get($data, "passport_series"),
            passport_number: Arr::get($data, "passport_number"),
            issue_date: Arr::get($data, "issue_date"),
            issued_by: Arr::get($data, "issued_by"),
            department_code: Arr::get($data, "department_code", null),
            individual_people_id: Arr::get($data, "individual_people_id", null),
        );
    }
}
