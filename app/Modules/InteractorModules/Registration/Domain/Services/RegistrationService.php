<?php

namespace App\Modules\InteractorModules\Registration\Domain\Services;

use App\Modules\InteractorModules\Registration\App\Data\DTO\Base\BaseDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Interactor\RegistrationInteractor;
use App\Modules\User\Domain\Models\User;

class RegistrationService
{
    public function __construct(
        private RegistrationInteractor $interatorRegister,
    ) { }

    /**
     * Проверяет нотифкацию user по email, phone и создаёт User
     * @param RegistrationDTO $dto
     *
     * @return array
     */
    public function registerUser(BaseDTO $dto) : array|User
    {
        return $this->interatorRegister->run($dto);
    }
}
