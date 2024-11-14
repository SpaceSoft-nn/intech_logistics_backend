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

        public readonly string $name,
        public readonly string $address,
        public readonly string $okved,
        public readonly string $founded_date,
        public readonly ?string $website,
        public readonly ?string $description,

        public readonly ?bool $remuved,
        public readonly OrganizationEnum $type,
        // public readonly TypeCabinetEnum $type_cabinet,

        public readonly ?string $phone,
        public readonly ?string $email,

        public readonly string $inn,
        public readonly ?string $kpp,
        public readonly string $registration_number,

    ) { }

    public function addOwner(string $uuid)
    {
        $this->owner_id = $uuid;
    }

    public static function make(

        string $name,
        string $address,
        string $okved,
        string $founded_date,
        OrganizationEnum $type,
        string $inn,
        // string $type_cabinet,
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
            type: $type,
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
            phone: Arr::get($data, 'phone' , null),
            email: Arr::get($data, 'email' , null),
            website: Arr::get($data, 'website' , null),
            type: OrganizationEnum::returnObjectByString(Arr::get($data, 'type', null)),
            description: Arr::get($data, 'description' , null),
            // type_cabinet: Arr::get($data, 'type_cabinet'),
            okved: Arr::get($data, 'okved' , null),
            founded_date: Arr::get($data, 'founded_date' , null),
            remuved: Arr::get($data, 'remuved' , null),
            inn: Arr::get($data, 'inn' , null),
            kpp: Arr::get($data, 'kpp' , null),
            registration_number: Arr::get($data, 'registration_number' , null),
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
