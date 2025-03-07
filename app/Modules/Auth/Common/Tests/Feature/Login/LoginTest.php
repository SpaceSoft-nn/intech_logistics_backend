<?php
namespace App\Modules\Auth\Common\Tests\Feature\Login;

use App\Modules\Auth\Common\Tests\TestCase;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Str;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login()
    {

        /** @var User */
        $user = User::factory(['active' => true])->hasAttached(
                Organization::factory(),
                ['type_cabinet' => TypeCabinetEnum::customer]
            )->for(PhoneList::factory(), 'phone')
            ->create();


        $postData = [
            "phone" => Str::remove('+', $user->phone->value),
            "password" => 'password',
        ];

        // Отправляем POST-запрос на endpoint
        $response = $this->postJson('/api/login', $postData);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(200);

        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('phone_list', [
            'id' => $user->phone->id,
        ]);

        $response->assertJsonStructure([
            "data" => [
                "access_token",
                "token_type",
                "expires_in",
            ],
            "message"
        ]);

    }
}
