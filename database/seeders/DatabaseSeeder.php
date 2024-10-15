<?php

namespace Database\Seeders;

use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\User\Domain\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([

                //Нужны первые сиды
            \App\Modules\Adress\Common\Database\Seeders\AdressSeeder::class,
            \App\Modules\OrderUnit\Common\Database\Seeders\OrderUnitSeeder::class,
            // \App\Modules\Transport\Common\Database\Seeders\TransportSeeder::class,

                //Дальше по цепочке сиды - эти сиды вынесены отдельно как склепок БД (Т.к по апи есть ограничение на бесплатные запросы)
            // \App\Modules\Matrix\Common\Database\Seeders\MatrixDistanceSeed::class,
            // \App\Modules\Matrix\Common\Database\Seeders\RegionEconomicFactorSeed::class,

        ]);

        {
            $email = EmailList::create([
                'value' => 'test@gmail.com',
                'status' => true,
            ]);

            $phone = PhoneList::create([
                'value' => '79200000000',
                'status' => true,
            ]);

            User::factory()->create([
                "password" => "Pass123!",
                "email_id" =>  $email->id,
                "phone_id" =>  $phone->id,
            ]);
        }



    }
}
