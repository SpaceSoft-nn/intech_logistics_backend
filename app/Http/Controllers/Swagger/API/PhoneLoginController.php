<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\get(
 *
 *      path="/api/login/phones",
 *      summary="Вернуть все организации которые принадлежат к phone + роль у этого user в орагнизации, если коллекция пуста, значит phone не привязан к организациям",
 *      tags={"Login\Registration"},
 *
 *
 *      @OA\Response(
 *           response=200,
 *           description="Успешный возврат всех данных об экономическом статусе регионов.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", ref="#/components/schemas/OrganizationLoginResource"),
 *               @OA\Property(property="message", type="string", example="Return Orders."),
 *           ),
 *       ),
 *
 *
 *
 *      @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 * )
 */
class PhoneLoginController extends Controller
{

}
