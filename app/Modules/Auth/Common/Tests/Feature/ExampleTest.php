<?php
namespace App\Modules\Auth\Common\Tests\Feature;


use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Domain\Models\User;
use App\Modules\Auth\Common\Tests\TestCase;
use App\Modules\Auth\App\Data\DTO\UserAttemptDTO;
use App\Modules\Auth\Domain\Services\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $serv;

    protected function setUp(): void {
        parent::setUp(); // Вызов метода родительского класса
        $this->serv = app(AuthService::class); // Инициализация $serv
    }

    /**
     * Тест на вход юзера и получение токена
     * @return [type]
     */
    public function test_attemptUserAuth()
    {
        $phone = '79200648827';
        $password = '123456';
        // $email = 'test2@example.com';

        {

            $token = $this->createUserToken();

            $array = compact('phone', 'password');

            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token['access_token'],
            ])->json('POST', '/api/login', $array);


            $response->assertStatus(200);


            $response->assertJsonStructure([
                "data" => [
                    "access_token",
                    "token_type",
                    "expires_in",
                ],
                "message"
            ]);
        }

        {
            $password = '1234567';

            $array = compact('phone', 'password');

            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token['access_token'],
            ])->json('POST', '/api/auth/login', $array);

            $response->assertStatus(404);
        }

    }

    /**
     * Получить user по токену Bearer
     * @return [type]
     */
    // public function test_getUserAuth()
    // {

    //     $token = $this->createUserToken();

    //     $response = $this->withHeaders([
    //         'Authorization' => 'Bearer ' . $token['access_token'],
    //     ])->json('POST', '/api/auth/user');

    //     $response->assertStatus(200);

    //     $response->assertJsonStructure([
    //         'data' => [],
    //         "message",
    //     ]);

    // }

    /**
     * Удалить актуальный токен
     * @return [type]
     */
    public function test_logout()
    {
        {
            $token = $this->createUserToken();

            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token['access_token'],
            ])->json('POST', '/api/auth/logout');

            $response->assertStatus(200);

            $response->assertJsonStructure([
                'data' => [],
                "message",
            ]);

        }
    }

    /**
     * Удаление акутального bearer токена и получение нового
     * @return [type]
    */
    public function test_refresh()
    {
        {
            $token = $this->createUserToken();

            $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token['access_token'],
            ])->json('POST', '/api/auth/refresh');


            $response->assertStatus(200);

            $response->assertJsonStructure([
                'data' => [],
                "message",
            ]);

        }

    }

    /**
     * Тест сервеса и метода loginUser - где мы возвращаем токен по модели
     * @return [type]
     */
    // public function test_loginUser()
    // {
    //     $user = $this->createUser();
    //     $array = $this->serv->loginUser($user);
    //     $this->assertIsArray($array);
    // }



//Private
    private function createUser($phone, $email, $password) : Model
    {


        $phoneList = PhoneList::factory()->state(['value' => $phone]);
        $emailList = EmailList::factory()->state(['value' => $email]);

        $user = User::factory()->hasAttached(
                Organization::factory(),
                ['type_cabinet' => TypeCabinetEnum::carrier]
            )
            ->for($phoneList, 'phone')
            ->for($emailList, 'email')->create(['password' => $password]);

        return $user;
    }

    private function createUserToken() : array
    {
        $phone = '79200648827';
        $password = '123456';
        $email = 'test2@example.com';


        //создаём user в бд
        $this->createUser(
            phone: $phone,
            password: $password,
            email: $email,
        );

        return $this->serv->attemptUserAuth(UserAttemptDTO::make($password, $phone, $email));
    }
}
