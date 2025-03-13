<?php

namespace App\Modules\User\App\Data\DTO\User\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

class UserVO extends BaseDTO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $father_name,
        public readonly string $password,

        public readonly UserRoleEnum $role,

        public ?string $email_id,
        public ?string $phone_id,
        public ?bool $active,
    ) {}


    public function setEmailId(string $id) : self
    {
        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $this->role,
            email_id: $id,
            phone_id: $this->phone_id,
            active: $this->active,
        );
    }

    public function setPhoneId(string $id) : self
    {

        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $this->role,
            email_id: $this->email_id,
            phone_id: $id,
            active: $this->active,
        );
    }

    public function setRole(UserRoleEnum $role)
    {
        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $role,
            email_id: $this->email_id,
            phone_id: $this->phone_id,
            active: $this->active,
        );
    }

    public function setActiveUser(bool $active)
    {
        return $this->make(
            first_name: $this->first_name,
            last_name: $this->last_name,
            father_name: $this->father_name,
            password: $this->password,
            role: $this->role,
            email_id: $this->email_id,
            phone_id: $this->phone_id,
            active: $active,
        );
    }


    public static function make(

        string $first_name,
        string $last_name,
        string $father_name,
        string $password,
        UserRoleEnum $role,
        ?string $email_id = null,
        ?string $phone_id = null,
        ?bool $active = null,

    ) : self {

        return new self(
            first_name: $first_name,
            last_name: $last_name,
            father_name: $father_name,
            password: $password,
            role: $role,
            email_id: $email_id,
            phone_id: $phone_id,
            active: $active,
        );

    }

    public function toArray() : array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' =>  $this->last_name,
            'father_name' =>  $this->father_name,
            'password' =>  $this->password,
            'role' =>  $this->role,
            'email_id' =>  $this->email_id,
            'phone_id' =>  $this->phone_id,
            'active' => $this->active,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {


        $first_name = Arr::get($data, 'first_name');
        $last_name =  Arr::get($data, 'last_name');
        $father_name =  Arr::get($data, 'father_name');
        $password =  Arr::get($data, 'password');
        $role =  UserRoleEnum::returnObjectByString(Arr::get($data, 'role', 'admin'));
        $email_id = Arr::get($data, 'email_user' , null);
        $phone_id = Arr::get($data, 'phone_user' , null);

        $active = false; #TODO Временно устанавливаем что польщователь для активирован, активировать вручную через БД

        if ($first_name === '' || $last_name === '' || $father_name === '' || $password === '') {
            throw new \InvalidArgumentException('Обязательные параметры не могут быть пустыми.', 500);
        }

        return new self(
            first_name: $first_name,
            last_name: $last_name,
            father_name: $father_name,
            password: $password,
            role: $role,
            email_id: $email_id,
            phone_id: $phone_id,
            active: $active,
        );
    }
}
