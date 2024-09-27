<?php


return [
    App\Providers\AppServiceProvider::class,

    #Custom Service
    App\Modules\Notification\App\Providers\Notification\NotificationServiceProvider::class,
    App\Modules\User\App\Providers\UserServiceProvider::class,
    App\Modules\Organization\App\Providers\OrganizationServiceProvider::class,
    App\Modules\InteractorModules\Registration\App\Providers\RegistrationServiceProvider::class, //сервес объединение User + Organization
    App\Modules\IndividualPeople\App\Providers\IndividualPeopleServiceProvider::class,
    App\Modules\Permission\App\Providers\PerrmissionServoceProvider::class, // Сервес прав по бинарной таблице
];
