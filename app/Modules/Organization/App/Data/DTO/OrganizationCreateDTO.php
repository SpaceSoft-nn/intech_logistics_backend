<?php

namespace App\Modules\Organization\App\Data\DTO;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use Illuminate\Contracts\Support\Arrayable;

class OrganizationCreateDTO extends BaseDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public readonly string $owner_id,

        public readonly string $name,
        public readonly string $address,
        public readonly string $industry,
        public readonly string $founded_date,
        public readonly ?string $website,
        public readonly ?string $description,

        public readonly ?bool $remuved,
        public readonly OrganizationEnum $type,

        public readonly ?string $phone,
        public readonly ?string $email,

        public readonly string $inn,
        public readonly ?string $kpp,
        public readonly ?string $registration_number,
        public readonly ?string $registration_number_individual,

    ) { }

    public static function make(
        string $owner_id,
        string $name,
        string $address,
        string $industry,
        string $founded_date,
        OrganizationEnum $type,
        string $inn,
        ?string $website = null,
        ?string $description = null,
        ?string $phone = null,
        ?string $email = null,
        ?bool $remuved = null,
        ?string $kpp = null,
        ?string $registration_number = null,
        ?string $registration_number_individual = null,
    ) : self {

        return new self(
            owner_id: $owner_id,
            name: $name,
            address: $address,
            website: $website,
            description: $description,
            industry: $industry,
            founded_date: $founded_date,
            phone: $phone,
            email: $email,
            remuved: $remuved,
            type: $type,
            inn: $inn,
            kpp: $kpp,
            registration_number: $registration_number,
            registration_number_individual: $registration_number_individual,
        );
    }

    public function toArray(): array
    {

        return [

            "name" => $this->name,
            "address" => $this->address,
            "industry" => $this->industry,
            "founded_date" => $this->founded_date,
            "website" => $this->website,
            "description" => $this->description,

            "remuved" => $this->remuved,
            "type" => $this->type,

            "phone" => $this->phone,
            "email" => $this->email,

            "inn" => $this->inn,
            "kpp" => $this->kpp,
            "registration_number" => $this->registration_number,
            "registration_number_individual" => $this->registration_number_individual,

        ];
    }

}
