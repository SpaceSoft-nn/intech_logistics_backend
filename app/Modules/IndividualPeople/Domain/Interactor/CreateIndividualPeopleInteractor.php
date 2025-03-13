<?php

namespace App\Modules\IndividualPeople\Domain\Interactor;

use DB;
use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;

use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\IndividualPeopleVO;
use App\Modules\IndividualPeople\App\Data\ValueObject\PassportVO;
use App\Modules\IndividualPeople\Domain\Actions\CreateIndividualPeople;
use App\Modules\IndividualPeople\Domain\Actions\Passport\CreatePassportAction;
use App\Modules\IndividualPeople\Domain\Models\Passport;

class CreateIndividualPeopleInteractor
{
    /**
     * @param CreateIndividualPeopleDTO $dto
     *
     * @return IndividualPeople
    */
    public static function execute(BaseDTO $dto) : IndividualPeople
    {
        return (new self())->run($dto);
    }

    /**
     * @param CreateIndividualPeopleDTO $dto
     *
     * @return IndividualPeople
    */
    private function run(BaseDTO $dto) : IndividualPeople
    {



        /**
        * @var IndividualPeople
        */
        $model = DB::transaction(function () use ($dto) {

            /** @var IndividualPeople */
            $individualPeople = $this->createIndividualPeople($dto->individualPeopleVO);

            /**
            * Создаём сущность passport
            * @var PassportVO
            */
            $passportVO_new = $dto->passportVO->setIndividualPeople($individualPeople->id);

            $this->createPassport($passportVO_new);

            return $individualPeople;
        });

        return $model;
    }

    private function createPassport(PassportVO $vo) : Passport
    {
        return CreatePassportAction::make($vo);
    }

    private function createIndividualPeople(IndividualPeopleVO $vo) : IndividualPeople
    {
        return CreateIndividualPeople::make($vo);
    }

}
