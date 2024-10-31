<?php

namespace App\Modules\Address\Domain\Actions\Address;

use App\Modules\Address\App\Data\DTO\ValueObject\AddressVO;
use App\Modules\Address\Domain\Models\Address;
use Exception;

class CreateAddressAction
{
    public function make(AddressVO $vo)
    {
        return (new self())->run($vo);
    }

    private function run(AddressVO $vo) : ?Address
    {

        try {

            return Address::createOrFirst(
                [
                    "latitude" => $vo->latitude,
                    "longitude" => $vo->longitude,
                ],
                $vo->toArrayNotNull()
            );

        } catch (\Throwable $th) {
            throw new Exception('Ошибка создание записи Address', 500);
        }

    }
}
