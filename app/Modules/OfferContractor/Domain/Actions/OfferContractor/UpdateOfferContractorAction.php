<?php

namespace App\Modules\OfferContractor\Domain\Actions\OfferContractor;

use DB;
use Exception;
use function App\Helpers\Mylog;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;

use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;

class UpdateOfferContractorAction
{
    public static function make(OfferContractorVO $vo, OfferContractor $model) : OfferContractor
    {
        return self::run($vo, $model);
    }


    /**
     * @param OfferContractorVO $vo
     * @param OfferContractor $offerContractor
     *
     * @return OfferContractor
     */
    private static function run(OfferContractorVO $vo, OfferContractor $model) : OfferContractor
    {

        try {

            //обновляем атрибуты модели через fill
            $model->fill($vo->toArrayNotNull());

            //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
            if ($model->isDirty()) { $model->save(); $model->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }


        return $model;
    }
}
