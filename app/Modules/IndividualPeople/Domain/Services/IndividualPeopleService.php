<?php

namespace App\Modules\IndividualPeople\Domain\Services;

use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\App\Data\DTO\CreateIndividualPeopleDTO;
use App\Modules\IndividualPeople\App\Repositories\IndividualPeopleRepository;
use App\Modules\IndividualPeople\Domain\Interactor\CreateIndividualPeopleInteractor;
use App\Modules\IndividualPeople\Domain\Interface\Service\IIndividualPeopleService;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;

class IndividualPeopleService implements IIndividualPeopleService
{
    public function __construct(
        private CreateIndividualPeopleInteractor $createIndividualPeopleInteractor,
        private IndividualPeopleRepository $rep,
    ) {}

    /**
     * Создание Individual People
     * @param CreateIndividualPeopleDTO $dto
     *
     * @return IndividualPeople
     */
    public function createIndividualPeople(BaseDTO $dto) : IndividualPeople
    {
        return $this->createIndividualPeopleInteractor::execute($dto);
    }
    /**а
     * Вернуть Individual people по uuid
     * @param string $uuid
     *
     * @return IndividualPeople|null
     */
    public function getIndividualPeople(string $uuid) :  ?IndividualPeople
    {
        return $this->rep->getById($uuid);
    }
}
