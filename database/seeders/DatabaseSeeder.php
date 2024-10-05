<?php

namespace Database\Seeders;

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
            \App\Modules\Adress\Common\Database\Seeders\AdressSeeder::class,
            \App\Modules\OrderUnit\Common\Database\Seeders\OrderUnitSeeder::class,
            // \App\Modules\PalletSpace\Common\Database\Seeders\PalletSpaceSeeder::class,
            // Добавьте другие сидеры, если нужно
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
