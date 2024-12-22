<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\User\Domain\Models\User;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([



                //Нужны первые сиды
            \App\Modules\Address\Common\Database\Seeders\AddressSeeder::class,
            \App\Modules\OrderUnit\Common\Database\Seeders\OrderUnitSeeder::class,
            \App\Modules\Transport\Common\Database\Seeders\TransportSeeder::class,

                //Статусы транспортировки - обязательно после OrderUnit
            \App\Modules\OrderUnit\Common\Database\Seeders\EnumTransportationStatusSeeder::class,

            //     //Дальше по цепочке сиды - эти сиды вынесены отдельно как склепок БД (Т.к по апи есть ограничение на бесплатные запросы)
            // // \App\Modules\Matrix\Common\Database\Seeders\MatrixDistanceSeed::class,
            // // \App\Modules\Matrix\Common\Database\Seeders\RegionEconomicFactorSeed::class,

            //     //Запускаем готовый склепок бд
            \App\Modules\Matrix\Common\Database\Seeders\RegionEconomicFactorFileSeed::class,
            \App\Modules\Matrix\Common\Database\Seeders\MatrixDistanceFileSeed::class,

            //     //Запуск seed - здесь будут создаваться: invoice_order, organization_order_units_invoce, agreement_order_accept, agreement_order - так же будут выбираться случаные OrderUnit из бд
            \App\Modules\OrderUnit\Common\Database\Seeders\AgreementOrderSeeder::class,

                //Здесь будут создавать предложения от перевозчика
            \App\Modules\OfferContractor\Common\Database\Seeders\OfferContractorSeeder::class,

                //Статусы транспортировки
            \App\Modules\OrderUnit\Common\Database\Seeders\EnumTransportationStatusSeeder::class,

            //Сиды для прода (Презентации)
            ProdeSeed::class,

                //Запуск seed Transfer - Даты доставок и т.д, могут быть случайны.
            // \App\Modules\Transfer\Common\Database\Seeders\TransferSeeder::class,

        ]);

    }
}
