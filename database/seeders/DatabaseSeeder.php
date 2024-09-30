<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Notification\Domain\Actions\List\CreateEmailListAction;
use App\Modules\Notification\Domain\Actions\List\CreatePhoneListAction;
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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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
