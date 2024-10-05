<?php
namespace App\Modules\Auth\Presentation\Http\Controllers;


use App\Modules\Auth\Domain\Exceptions\Error\ExceptionAccessIsDenied;
use App\Modules\Auth\Domain\Exceptions\Error\ExceptionInvalidRequest;
use App\Modules\Auth\Domain\Exceptions\Error\ExceptionNotFound;
use App\Modules\Auth\Domain\Exceptions\Error\ExceptionServerError;
use App\Modules\Auth\Domain\Exceptions\Error\ExceptionUnauthorized;
use App\Modules\Auth\Domain\Exceptions\Error\ExceptionUnprocessedObject;


/**
 * @OA\Info(
 *      title="Payment QR Service API",
 *      version="1.0.0"
 * ),
 * @OA\PathItem(
 *      path="/api/swagger"
 * ),
 *
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *     )
 * ),
 *
 * @OA\Schema(
 *    schema="BearerToken",
 *    title="Bearer Token Object",
 *    @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3MTQwMDMwNTcsImV4cCI6MTcxNDAwNjY1NywibmJmIjoxNzE0MDAzMDU3LCJqdGkiOiJaampTNWRmOHZtdHNZbWJ0Iiwic3ViIjoiMSIsInBydiI6IjRhNmUyNTJkNDljYzM1ZjlhNmQyODk3ZmRlNGY5MzE0NmU3YzgwMmMifQ.6J4NAHBKlRIG5ZAtgIwXHuToFnG1mCCXwgxrf6rL9DY"),
 *    @OA\Property(property="token_type", type="number", example="Bearer"),
 *    @OA\Property(property="expires_in", type="integer", example="3600"),
 * ),
 *
 *
 * @OA\Schema(
 *    schema="OrderUnitResource",
 *    title="Order Unit json Resource",
 *    @OA\Property(property="id", type="string", format="uuid"),
 *    @OA\Property(property="delivery_start", type="string", format="date-time"),
 *    @OA\Property(property="delivery_end", type="string", format="date-time"),
 *    @OA\Property(property="adress_start_id", ref="#/components/schemas/AdressResource"),
 *    @OA\Property(property="adress_end_id", ref="#/components/schemas/AdressResource"),
 *    @OA\Property(property="body_volume", type="number", format="float"),
 *    @OA\Property(property="order_total", type="number", format="float"),
 *    @OA\Property(property="description", type="string"),
 *    @OA\Property(property="product_type", type="string"),
 *    @OA\Property(property="order_status", type="string"),
 *    @OA\Property(property="user_id", ref="#/components/schemas/UserResource"),
 *    @OA\Property(property="organization_id", ref="#/components/schemas/OrganizationResource"),
 * ),
 *
 * @OA\Schema(
 *    schema="AdressResource",
 *    title="Адрес json Ресурс",
 *    @OA\Property(property="id", type="integer", format="int64"),
 *    @OA\Property(property="region", type="string"),
 *    @OA\Property(property="city", type="string"),
 *    @OA\Property(property="street", type="string"),
 *    @OA\Property(property="building", type="string"),
 *    @OA\Property(property="apartment", type="string"),
 *    @OA\Property(property="house_number", type="string"),
 *    @OA\Property(property="postal_code", type="string"),
 *    @OA\Property(property="type_adress", type="string"),
 *    @OA\Property(property="latitude", type="number", format="float"),
 *    @OA\Property(property="longitude", type="number", format="float"),
 * ),
 *
 * @OA\Schema(
 *    schema="OrganizationResource",
 *    title="Ресурс Организации",
 *    @OA\Property(property="owner_id", type="integer", format="int64"),
 *    @OA\Property(property="name", type="string"),
 *    @OA\Property(property="address", ref="#/components/schemas/AdressResource"),
 *    @OA\Property(property="website", type="string", format="uri"),
 *    @OA\Property(property="description", type="string"),
 *    @OA\Property(property="industry", type="string"),
 *    @OA\Property(property="founded_date", type="string", format="date"),
 *    @OA\Property(property="phone", type="string"),
 *    @OA\Property(property="email", type="string", format="email"),
 *    @OA\Property(property="remuved", type="boolean"),
 *    @OA\Property(property="type", type="string"),
 *    @OA\Property(property="inn", type="string"),
 *    @OA\Property(property="kpp", type="string"),
 *    @OA\Property(property="registration_number", type="string"),
 *    @OA\Property(property="registration_number_individual", type="string"),
 * ),
 *
 *
 *
 */
abstract class Controller
{
    protected function exceptionNotFound(string $message, int $code = 404)
    {
        ($message === '') ? $message = 'Не найдено (страница или другой ресурс не существует)' : '';
        throw new ExceptionNotFound($message, $code);
    }

    protected function exceptionAccessIsDenied(string $message , int $code = 403)
    {
        ($message === '') ? $message = 'Вы вошли в систему, но доступ к запрашиваемой области запрещен.' : '';
        throw new ExceptionAccessIsDenied($message, $code);
    }

    protected function exceptionUnauthorized(string $message = '', int $code = 401)
    {
        ($message === '') ? $message = 'Не авторизован' : '';
        throw new ExceptionUnauthorized($message, $code);
    }


    protected function exceptionInvalidRequest(string $message, int $code = 400)
    {
        ($message === '') ? $message = 'Неверный запрос (что-то не так с URL-адресом или параметрами)' : '';
        throw new ExceptionInvalidRequest($message, $code);
    }

    protected function exceptionUnprocessedObject(string $message , int $code = 422)
    {
        ($message === '') ? $message = 'Необрабатываемый объект (проверка не удалась)' : '';
        throw new ExceptionUnprocessedObject($message, $code);
    }

    protected function exceptionServerError(string $message , int $code = 500)
    {
        ($message === '') ? $message = 'Общая ошибка сервера' : '';
        throw new ExceptionServerError($message, $code);
    }

    protected function abort_unless($boolean, int $code, string $message = ''): void
    {


        if(!(bool) $boolean){

            match($code){

                404 => $this->exceptionNotFound($message),
                403 => $this->exceptionAccessIsDenied($message),
                401 => $this->exceptionUnauthorized($message),
                400 => $this->exceptionInvalidRequest($message),
                422 => $this->exceptionUnprocessedObject($message),
                500 => $this->exceptionServerError($message),

            };

        }

    }

    private function isMessage($message){
        return ($message === '') ? $message = $message : '' ;
    }
}
