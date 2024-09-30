<?php
namespace App\Modules\Auth\App\Data\DTO;

use Illuminate\Contracts\Support\Arrayable;

class UserAttemptDTO extends BaseDTO implements Arrayable
{
    public function __construct(

        public readonly ?string $phone,

        public readonly ?string $email,

        public readonly string $password,

    ) { }

    public static function make(string $password, ?string $phone = null, ?string $email = null) : self
    {
        return new self(
            phone : $phone,
            email : $email,
            password : $password,
        );
    }

    public function toArray(): array {

        $data = [
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => $this->password,
        ];

        //фильтр для удаление значений с null
        $data = collect($data)->filter(function($value){
            return $value !== null;
        })->toArray();

        return $data;
    }

    public function toArrayNotNull() : array
    {
        $arrayFilter = array_filter($this->toArray(), function($value) {
            return !is_null($value);
        });

        return $arrayFilter;
    }

}
