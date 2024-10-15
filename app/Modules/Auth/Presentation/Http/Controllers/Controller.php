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
 *
 * @OA\Schema(
 *    schema="OrderUnitResource",
 *    title="Json Ресурс Order Unit",
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
 *    title="Json Ресурс Адресса",
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
 *
 * @OA\Schema(
 *    schema="TransferResource",
 *    title="Ресурс Трансфера",
 *    @OA\Property(property="transport_id", type="integer", format="int64"),
 *    @OA\Property(property="delivery_start", type="string", format="date-time"),
 *    @OA\Property(property="delivery_end", type="string", format="date-time"),
 *    @OA\Property(property="adress_start_id", ref="#/components/schemas/AdressResource"),
 *    @OA\Property(property="adress_end_id", ref="#/components/schemas/AdressResource"),
 *    @OA\Property(property="order_total", type="number", format="float"),
 *    @OA\Property(property="description", type="string"),
 *    @OA\Property(property="body_volume", type="number", format="float"),
 * ),
 *
 * @OA\Schema(
 *   schema="MatrixDistanceResource",
 *   title="Matrix Distance Resource",
 *   @OA\Property(property="city_start_gar_id", type="string", format="uuid", description="ID города отправления"),
 *   @OA\Property(property="city_end_gar_id", type="string", format="uuid", description="ID города назначения"),
 *   @OA\Property(property="city_name_start", type="string", description="Название города отправления"),
 *   @OA\Property(property="city_name_end", type="string", description="Название города назначения"),
 *   @OA\Property(property="distance", type="number", format="float", description="Расстояние между городами в километрах"),
 * ),
 *
 * @OA\Schema(
 *   schema="RegionEconomicFactorResource",
 *   title="Ресурс региона",
 *   @OA\Property(property="id", type="string", format="uuid", description="Уникальный идентификатор региона (UUID)"),
 *   @OA\Property(property="region_start_gar_id", type="string", format="uuid", description="Значение Гар для области отправления (UUID)"),
 *   @OA\Property(property="region_end_gar_id", type="string", format="uuid", description="Значение Гар для области прибытия (UUID)"),
 *   @OA\Property(property="region_name_start", type="string", description="Название области отправления"),
 *   @OA\Property(property="region_name_end", type="string", description="Название области прибытия"),
 *   @OA\Property(property="factor", type="number", format="float", description="Коэффициент"),
 *   @OA\Property(property="price", type="string", format="decimal", description="Цена за 1 км", example="123.45"),
 * ),
 *
 * @OA\Schema(
 *   schema="OrganizationResource",
 *   title="Организация",
 *   description="Информация об организации",
 *
 *   @OA\Property(property="name", type="string", description="Название организации", maxLength=101, minLength=2),
 *   @OA\Property(property="address", type="string", description="Адрес организации", maxLength=255, minLength=12),
 *   @OA\Property(property="phone", type="string", description="Телефон организации"),
 *   @OA\Property(property="email", type="string", format="email", description="Email организации", maxLength=100),
 *   @OA\Property(property="website", type="string", description="Вебсайт организации"),
 *   @OA\Property(
 *     property="type",
 *     type="string",
 *     description="Тип организации",
 *     enum={"ooo", "ie"}
 *   ),
 *   @OA\Property(property="description", type="string", nullable=true, description="Описание организации"),
 *   @OA\Property(property="industry", type="string", nullable=true, description="Индустрия организации"),
 *   @OA\Property(property="founded_date", type="string", format="date", nullable=true, description="Дата основания организации"),
 *   @OA\Property(property="inn", type="string", description="ИНН организации", pattern="^(([0-9]{12})|([0-9]{10}))?$"),
 *   @OA\Property(
 *     property="type_cabinet",
 *     type="string",
 *     description="Тип кабинета",
 *     enum={"Заказчик", "Склад", "Перевозчик"}
 *   ),
 *   @OA\Property(
 *     property="kpp",
 *     type="string",
 *     description="КПП (для ООО)",
 *     pattern="^([0-9]{9})?$",
 *     nullable=true
 *   ),
 *   @OA\Property(
 *     property="registration_number",
 *     type="string",
 *     description="ОГРН (для ООО)",
 *     pattern="^([0-9]{13})?$",
 *     nullable=true
 *   ),
 *   @OA\Property(
 *     property="registration_number_individual",
 *     type="string",
 *     description="ОГРНИП (для ИП)",
 *     pattern="^\d{15}$",
 *     nullable=true
 *   ),
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
