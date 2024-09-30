<?php

namespace App\Modules\InteractorModules\Registration\Domain\Interactor;

use App\Modules\InteractorModules\Registration\App\Data\DTO\Base\BaseDTO;
use App\Modules\Notification\Domain\Services\Notification\NotificationService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Services\UserService;
use Exception;
use Illuminate\Database\Eloquent\Model;
use RegistrationDTO;

class RegistrationInteractor
{
    public function __construct(
        public UserService $userService,
        public NotificationService $NotificationService,
    ) {}

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
        if(!is_null($data)) { return $this->NotificationService->emailConfirmed($data); }
    }

    /**
     * Проверка на подтверждения Phone
     * @param string $data
     *
     * @return ?Model
     */
    private function confirmPhone(string $data) : ?Model
    {
        if(!is_null($data)) { return $this->NotificationService->phoneConfirmed($data); }
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

    /**
     * @param RegistrationDTO $dto
     *
     * @return array|User
     */
    public function run(BaseDTO $dto) : array|User
    {
        /**
        * @var UserCreateDTO
        */
        $userDTO = $dto->userDTO;

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

        //вызываем сервес для создание user
        $user = $this->userService->createUser($userDTO);

        return $user;
    }
}
