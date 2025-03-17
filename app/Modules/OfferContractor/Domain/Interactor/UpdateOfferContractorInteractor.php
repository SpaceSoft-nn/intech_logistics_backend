<?php

namespace App\Modules\OfferContractor\Domain\Interactor;

use DB;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Actions\OfferContractor\UpdateOfferContractorAction;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;

class UpdateOfferContractorInteractor
{

    public static function execute(OfferContractorVO $vo, OfferContractor $model) : OfferContractor
    {
        return (new self())->run($vo, $model);
    }

    /**
     * @param OfferContractorVO $dto
     *
     * @return OfferContractor
     */
    private function run(OfferContractorVO $vo, OfferContractor $model) : OfferContractor
    {
        /**
         * @var OfferContractor
        */
        $offerContractor = DB::transaction(function () use ($vo, $model) {

            /**
            * @var OfferContractor
            */
            $offerContractor = $this->updateOfferContractor($vo, $model);


            return $offerContractor;

        });

        return $offerContractor;
    }

    private function updateOfferContractor(OfferContractorVO $vo, OfferContractor $model) : OfferContractor
    {
        return UpdateOfferContractorAction::make($vo, $model);
    }


}
