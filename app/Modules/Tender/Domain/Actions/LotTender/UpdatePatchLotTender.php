<?php

namespace App\Modules\Tender\Domain\Actions\LotTender;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\App\Data\DTO\UpdateLotTenderDTO;


class UpdatePatchLotTender
{
    public static function make(LotTender $lotTender, UpdateLotTenderDTO $dto) : LotTender
    {
        return app(self::class)->run($lotTender, $dto);
    }

    private function run(LotTender $lotTender, UpdateLotTenderDTO $dto) : LotTender
    {

        try {

            //обновляем атрибуты модели через fill
            $lotTender->fill($dto->toArrayNotNull());

            //проверяем данные на 'грязь' - если данные отличаются от старого состояние модели, то обновляем сущность
            if ($lotTender->isDirty()) { $lotTender->save(); $lotTender->refresh(); }

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);

        }

        return $lotTender;
    }
}
