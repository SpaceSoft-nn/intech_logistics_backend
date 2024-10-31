<?php

namespace App\Modules\InteractorModules\Registration\Common\Tests\Feature;

use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Interactor\RegistrationInteractor;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    public function test_registration()
    {
        $iterator = app(RegistrationInteractor::class);

        //TODO Сделать для Email (factory из цепочки подтврждения)
        $emailList = EmailList::factory()->create();

        $dto = RegistrationDTO::make(
            UserCreateDTO::make(
                UserVO::make(
                    first_name: 'test',
                    last_name: 'test',
                    father_name: 'test',
                    password: 'test',
                    role: UserRoleEnum::admin,
                    personal_area_id: null,
                    email_id: $emailList->id,
                    phone_id: null,
                )
            ),
            email: 'qjq3@mail.ru',
        );

    }
}
