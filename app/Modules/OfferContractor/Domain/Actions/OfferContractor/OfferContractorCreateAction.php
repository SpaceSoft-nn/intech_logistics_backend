<?php

namespace App\Modules\OfferContractor\Domain\Actions\OfferContractor;

use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use Exception;

use function App\Helpers\Mylog;

class OfferContractorCreateAction
{
    public static function make(OfferContractorVO $vo) : OfferContractor
    {
        return (new self())->run($vo);
    }

    private function run(OfferContractorVO $vo) : OfferContractor
    {


        try {

            $offerContractor = OfferContractor::create($vo->toArrayNotNull());

        } catch (\Throwable $th) {

            Mylog('Ошибка в OfferContractorCreateAction при создании записи: ' . $th);
            throw new Exception('Ошибка в OfferContractorCreateAction', 500);

        }

        return $offerContractor;
    }
}
