<?php

namespace App\Modules\Address\Domain\Actions\Address;

use App\Modules\Address\App\Data\DTO\ValueObject\AddressVO;
use App\Modules\Address\Domain\Models\Address;
use Exception;

use function App\Helpers\Mylog;

class UpdateAddressAction
{
    public static function make(AddressVO $vo, Address $address)  : Address
    {
        return self::run($vo, $address);
    }

    private static function run(AddressVO $vo, Address $address) : Address
    {

        try {

            //обновляем атрибуты модели через fill
            $address->fill($vo->toArrayNotNull());

            //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
            if ($address->isDirty()) { $address->save(); $address->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $address;

    }
}
