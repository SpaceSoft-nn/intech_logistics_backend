<?php

use App\Modules\OrderUnit\App\Providers\OrderUnitServiceProvider;

return [
    App\Providers\AppServiceProvider::class,

        #Custom Service
    App\Modules\Notification\App\Providers\Notification\NotificationServiceProvider::class,
    App\Modules\User\App\Providers\UserServiceProvider::class,
    App\Modules\Organization\App\Providers\OrganizationServiceProvider::class,
    App\Modules\InteractorModules\Registration\App\Providers\RegistrationServiceProvider::class, //сервес объединение User + Organization
    App\Modules\IndividualPeople\App\Providers\IndividualPeopleServiceProvider::class,
    App\Modules\Permission\App\Providers\PerrmissionServoceProvider::class, // Сервес прав по бинарной таблице
    App\Modules\IndividualFace\App\Providers\IndividualFaceServiceProvider::class,
    App\Modules\Transaport\App\Providers\TransportServiceProvider::class,
    App\Modules\PalletSpace\App\Providers\PalletSpaceServiceProvider::class,
    App\Modules\Adress\App\Providers\AdressServiceProvider::class,
    App\Modules\OrderUnit\App\Providers\OrderUnitServiceProvider::class,

        #Auth Service
    App\Modules\Auth\App\Providers\AuthServiceProvider::class,
];
