<?php

namespace App\Modules\Tender\Domain\Interactor;


use DB;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\App\Data\DTO\UpdateLotTenderDTO;
use App\Modules\Tender\Domain\Actions\LotTender\UpdatePatchLotTender;

// Обновление заказа - добавление важных значений для заказа
final class UpdatePatchLotTenderInteractor
{

    public function execute(LotTender $lotTender, UpdateLotTenderDTO $dto) : LotTender
    {
        return app(self::class)->run($lotTender, $dto);
    }


    private function run(LotTender $lotTender, UpdateLotTenderDTO $dto) : LotTender
    {

        /** @var LotTender */
        $lotTender = DB::transaction(function () use ($lotTender, $dto) {

            return $this->updateLotTender($lotTender, $dto);

        });

        return $lotTender;
    }

    private function updateLotTender(LotTender $lotTender, UpdateLotTenderDTO $dto) : LotTender
    {
        return UpdatePatchLotTender::make($lotTender, $dto);
    }


}
