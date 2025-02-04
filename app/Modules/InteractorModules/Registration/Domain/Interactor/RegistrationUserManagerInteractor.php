<?php

namespace App\Modules\InteractorModules\Registration\Domain\Interactor;

use Exception;
use function App\Helpers\Mylog;
use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use App\Modules\Base\Error\BusinessException;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;

use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;
use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistratiorUserManagerDTO;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;

// Бизнес логика для создание заказа, когда заказ создатёся от Тендера
class RegistrationUserManagerInteractor
{

    public function __construct(
        private OrganizationRepository $orgRep,
        private UserRepository $userRep,
        private UserService $userService,
    ) { }


    public function execute(RegistratiorUserManagerDTO $dto)
    {
        return $this->run($dto);
    }


    private function run(RegistratiorUserManagerDTO $dto) : User
    {
        /** @var Organization */
        $organization = $dto->organization;

        /** @var User */
        $owner = User::find($organization->owner_id);

        $personal_area = $this->userRep->isOwnerPersonalArea($owner);

        if(is_null($personal_area)) {
            //Делаем навсякий-случай проверку
            Mylog('Ошибка в UserManagerCreateInteractor, personal_area - не был найден');
            throw new Exception(code: 500);
        }

        //устанавливаем роль менеджера и что он будет не активен
        /** @var UserVO */
        $userVO = $dto->userVO->setRole(UserRoleEnum::manager)->setActiveUser(false);

        //устанавливаем user телефон или email
        $userVO = $this->setEmailOrPhone(
            userVO: $userVO,
            phone_id: $dto->phone_id,
            email_id: $dto->email_id,
        );

        /** @var TypeCabinetEnum */
        $typeCabinet = $this->orgRep->getTypeCabinet($owner, $organization); //получаем тип кабинета по owner + org


        $user = $this->userService->createUserManager(
            UserManagerCreateDTO::make(
                userVO: $userVO,
                personalArea: $personal_area,
                organization: $dto->organization,
                type_cabinet: $typeCabinet,
            )
        );

        return $user;

    }

    //здесь создаём и сразу устанавливаем auth:true для phone/email
    private function setEmailOrPhone(UserVO $userVO, ?string $phone_id = null, ?string $email_id = null) : UserVO
    {
        $email = $email_id;
        $phone = $phone_id;

        #TODO - Это логика при подтверждении сотового или email (мы её убираем на время)
        {
            //Проверяем подтверждён ли phone/email
            $model_confirm = $this->isAccessNotification(email: $email, phone: $phone);

            //Если нет выкидываем массив с сообщением
            if(empty($model_confirm['data'])) { $this->arrayResponseConfrimNotification(); }
        }

        //Получаем id emailList or PhoneList
        $notifyId = $model_confirm['data']->id;

        //Устанавливаем для DTO email_id или phone_id
        switch ($model_confirm['type']) {
            case 'phone':
            {
                return $userVO->setPhoneId($notifyId);
                break;
            }

            case 'email':
            {
                return $userVO->setEmailId($notifyId);
                break;
            }

            default:
            {
                throw new Exception('Неизвстный тип нотифкаици при создании User', 500);
                break;
            }
        }


    }

    private function arrayResponseConfrimNotification() : array
    {
        //возможно в будущем при пересмотре регистрации эту логику нужно переделать
        throw new BusinessException('Подтвердите почту или телефон.', 403);
    }

    /**
     * Проверка на подтверждения Email
     * @param string $data
     *
     * @return ?Model
     */
    private function confirmEmail(string $data) : ?Model
    {
        $model = EmailList::create([
            'value' => $data,
            'status' => true,
        ]);

        return $model ?? null;

        #TODO убираем эту логику и просто создаём запись (потом вернуть как всё было)
        // if(!is_null($data)) { return $this->NotificationService->emailConfirmed($data); }
    }

    /**
     * Проверка на подтверждения Phone
     * @param string $data
     *
     * @return ?Model
     */
    private function confirmPhone(string $data) : ?Model
    {

        $model = PhoneList::create([
            'value' => $data,
            'status' => true,
        ]);

        return $model ?? null;
        #TODO убираем эту логику и просто создаём запись (потом вернуть как всё было)
        // if(!is_null($data)) { return $this->NotificationService->phoneConfirmed($data); }
    }

    private function isAccessNotification(string $email = null, string $phone = null) : array
    {
        if(is_null($email)) {

            return [
                'data' => $this->confirmPhone($phone),
                'type' => 'phone',
            ];

        } else {

            return [
                'data' => $this->confirmEmail($email),
                'type' => 'email',
            ];
        }
    }

}
