<?php

namespace Database\Seeders;

use App\Modules\Matrix\Common\Database\Seeders\MatrixDistanceSeed;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
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

                //Дальше по цепочке сиды
            \App\Modules\Matrix\Common\Database\Seeders\MatrixDistanceSeed::class,

        ]);

        EmailList::create([
            'value' => 'qjq3@mail.ru',
            'status' => true,
        ]);

        PhoneList::create([
            'value' => '79200264425',
            'status' => true,
        ]);

    }
}
