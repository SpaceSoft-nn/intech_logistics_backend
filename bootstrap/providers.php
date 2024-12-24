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
    App\Modules\Transport\App\Providers\TransportServiceProvider::class,
    App\Modules\Address\App\Providers\AddressServiceProvider::class,
    App\Modules\OrderUnit\App\Providers\OrderUnitServiceProvider::class,
    App\Modules\Transfer\App\Providers\TransferServiceProvider::class,
    App\Modules\Matrix\App\Providers\MatrixServiceProvider::class,
    App\Modules\GAR\App\Providers\GARServiceProvider::class,
    App\Modules\InteractorModules\AgreementTransfer\App\Providers\AgreementTransferServiceProvider::class,
    App\Modules\OfferContractor\App\Providers\OfferContractorServiceProvider::class,

        #Interactor Service
    App\Modules\InteractorModules\AddressOrder\App\Providers\AddressOrderServiceProvide::class,
    App\Modules\InteractorModules\OrganizationOrderInvoice\App\Providers\OrganizationOrderInvoiceServiceProvider::class,


        #Auth Service
    App\Modules\Auth\App\Providers\AuthServiceProvider::class,

];
