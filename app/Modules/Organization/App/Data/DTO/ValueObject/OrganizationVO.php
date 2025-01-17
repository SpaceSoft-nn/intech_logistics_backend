<?php

namespace App\Modules\Organization\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

final class OrganizationVO extends BaseDTO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(

        public ?string $owner_id,

        public  string $name,
        public  string $address,
        public  ?string $okved,
        public  string $founded_date,
        public  ?string $website,
        public  ?string $description,

        public  ?bool $remuved,
        public  OrganizationEnum $type,
        // public readonly TypeCabinetEnum $type_cabinet, // Для VO она не нужна, но нужна в проежуточной таблице user_organization

        public  ?string $phone,
        public  ?string $email,

        public  string $inn,
        public  ?string $kpp,
        public  string $registration_number,

    ) { }

    public function addOwner(string $uuid) : self
    {
        return self::make(
            owner_id: $uuid,
            name: $this->name,
            address: $this->address,
            website: $this->website,
            description: $this->description,
            okved: $this->okved,
            founded_date: $this->founded_date,
            // type_cabinet: TypeCabinetEnum::stringByCaseToObject($type_cabinet),
            phone: $this->phone,
            email: $this->email,
            remuved: $this->remuved,
            type: $this->type->name,
            inn: $this->inn,
            kpp: $this->kpp,
            registration_number: $this->registration_number,
        );
    }

    public static function make(

        string $name,
        string $address,
        string $founded_date,
        string $type,
        string $inn,
        // string $type_cabinet,
        ?string $okved = null,
        ?string $owner_id,
        ?string $website = null,
        ?string $description = null,
        ?string $phone = null,
        ?string $email = null,
        ?bool $remuved = null,
        ?string $kpp = null,
        ?string $registration_number = null,
    ) : self {

        return new self(
            owner_id: $owner_id,
            name: $name,
            address: $address,
            website: $website,
            description: $description,
            okved: $okved,
            founded_date: $founded_date,
            // type_cabinet: TypeCabinetEnum::stringByCaseToObject($type_cabinet),
            phone: $phone,
            email: $email,
            remuved: $remuved,
            type: OrganizationEnum::stringByCaseToObject($type),
            inn: $inn,
            kpp: $kpp,
            registration_number: $registration_number,
        );
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            owner_id: Arr::get($data, 'owner_id', null),
            name: Arr::get($data, 'name' , null),
            address: Arr::get($data, 'address'),
            phone: Arr::get($data, 'phone_org' , null),
            email: Arr::get($data, 'email_org' , null),
            website: Arr::get($data, 'website' , null),
            type: (Arr::get($data, 'type', null)),
            description: Arr::get($data, 'description' , null),
            // type_cabinet: Arr::get($data, 'type_cabinet'),
            okved: Arr::get($data, 'okved' , null),
            founded_date: Arr::get($data, 'founded_date' , null),
            remuved: Arr::get($data, 'remuved' , null),
            inn: Arr::get($data, 'inn' , null),
            kpp: Arr::get($data, 'kpp' , null),
            registration_number: Arr::get($data, 'registration_number'),
        );
    }

    public function toArray(): array
    {

        return [

            "owner_id" => $this->owner_id,
            "name" => $this->name,
            "address" => $this->address,
            "okved" => $this->okved,
            "founded_date" => $this->founded_date,
            "website" => $this->website,
            "description" => $this->description,

            // "type_cabinet" => $this->type_cabinet?->value,

            "remuved" => $this->remuved,
            "type" => $this->type,

            "phone" => $this->phone,
            "email" => $this->email,

            "inn" => $this->inn,
            "kpp" => $this->kpp,
            "registration_number" => $this->registration_number,

        ];
    }

}
