<?php

namespace App\Modules\InteractorModules\Registration\Domain\Interactor;

use App\Modules\InteractorModules\Registration\App\Data\DTO\CreateRegisterAllDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Notification\Domain\Services\Notification\NotificationService;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Services\UserService;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Model;

#TODO Костыльная и быстрая логика которую нужно будет переделать!!!
class RegistrationUserAndOrganizationInteractor
{
    public function __construct(
        public UserService $userService,
        private UserRepository $repUser,
        private NotificationService $NotificationService,
        // public NotificationService $NotificationService,
        public OrganizationService $orgService,
    ) {}



    public function run(CreateRegisterAllDTO $dto) : array
    {
        /** @var array */
        $array = DB::transaction(function () use ($dto) {

            //Заранее для DTO Устанавливаем phone_id/email_id в UserVO

            $dto = CreateRegisterAllDTO::make(
                registrationDTO: $this->setEmailOrPhone($dto->registrationDTO),
                organizationVO: $dto->organizationVO,
                type_cabinet: $dto->type_cabinet,
            );

            /**
            * @var UserCreateDTO
            */
            $userDTO = $dto->registrationDTO->userDTO;


            //вызываем сервес для создание user
            /** @var User */
            $user = $this->userService->createUser($userDTO);


            /** @var OrganizationVO */
            $organizationVO = $dto->organizationVO;

            /** @var OrganizationCreateDTO */
            $organizationCreateDTO = OrganizationCreateDTO::make(
                organizationVO: $organizationVO,
                user: $user,
                type_cabinet: $dto->type_cabinet,
            );

            /** @var Organization */
            $org = $this->orgService->createOrganization($organizationCreateDTO);

            return [
                'user' => $user,
                'organization' => $org,
            ];

        });

        return $array;
    }

    private function setEmailOrPhone(RegistrationDTO $dto) : RegistrationDTO
    {
        /**
        * @var UserCreateDTO
        */
        $userDTO = $dto->userDTO;

        #TODO - Это логика при подтверждении сотового или email (мы её убираем на время)
        {
            //Проверяем подтверждён ли phone/email
            $model_confirm = $this->isAccessNotification(email: $dto->email, phone: $dto->phone);

                //Если нет выкидываем массив с сообщением
            if(empty($model_confirm['data'])) { return $this->arrayResponseConfrimNotification(); }
        }

        //Получаем id emailList or PhoneList
        $notifyId = $model_confirm['data']->id;

        //Устанавливаем для DTO email_id или phone_id
        switch ($model_confirm['type']) {
            case 'phone':
            {
                $userDTO->userVO->setPhoneId($notifyId);
                break;
            }

            case 'email':
            {
                $userDTO->userVO->setEmailId($notifyId);
                break;
            }

            default:
            {
                throw new Exception('Неизвстный тип нотифкаици при создании User', 500);
                break;
            }
        }


        return RegistrationDTO::make(
            userDTO: $userDTO,
            phone : $dto->phone,
            email : $dto->email,
        );
    }

    private function arrayResponseConfrimNotification() : array
    {
        return [
            'message' => "Подтвердите почту или телефон.",
            'status' => false,
        ];
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
