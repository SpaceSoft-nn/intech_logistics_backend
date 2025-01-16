<?php

namespace App\Modules\Avizo\Domain\Actions;

use App\Modules\Avizo\App\Data\ValueObject\AvizoPhoneVO;
use App\Modules\Avizo\Domain\Models\AvizoPhone;

use Exception;

use function App\Helpers\Mylog;

class CreateWeekPeriodAction
{

    public static function make(AvizoPhoneVO $vo) : AvizoPhone
    {
        return (new self())->run($vo);
    }

    private function run(AvizoPhoneVO $vo) : AvizoPhone
    {

        try {

            $model = AvizoPhone::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $model;
    }
}
