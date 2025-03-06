<?php
namespace App\Modules\Auth\Common\Tests\Feature\Registration;

use App\Modules\Auth\Common\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Str;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration()
    {

        $postData = [
            "phone"=> "79200000009",
            "organization"=> [
                "name"=> 'Компания',
                "address"=> 'Москва улица кима, дом 258',
                "type"=> "legal",
                "inn"=> "5259149841",
                "kpp"=> "525901001",
                "registration_number"=> "1205200036964",
                "founded_date"=> "01.05.2020",
                "okved"=> "46.51",
                "remuved"=> false,
                "type_cabinet"=> "customer"
            ],
            "first_name"=> 'Иван',
            "last_name"=> 'Иванович',
            "father_name"=> 'Иванов',
            "password"=> "password",
            "password_confirmation"=> "password",
            "agreement"=> true
        ];

        // Отправляем POST-запрос на endpoint
        $response = $this->postJson('/api/registration', $postData);

        // Проверяем, что статус ответа 201 OK
        $response->assertStatus(201);

        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('organizations', [
            'registration_number' => $postData['organization']['registration_number'],
        ]);

        // Проверка наличия заказа в базе данных
        $this->assertDatabaseHas('phone_list', [
            'value' => $postData['phone'],
        ]);

        $response->assertJsonStructure([
            "data" => [
                'token' => [
                    "access_token",
                    "token_type",
                    "expires_in",
                ],
                'organization',
                'user',
            ],

            "message"
        ]);

    }
}
