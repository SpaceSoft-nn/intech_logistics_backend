<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\post(
 *
 *      path="/api/login/phones",
 *      summary="Вернуть все организации которые принадлежат к phone + роль у этого user в орагнизации, если коллекция пуста, значит phone не привязан к организациям",
 *      tags={"Login\Registration"},
 *      @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               @OA\Property(property="phone", type="string", description="User's phone number", pattern="^\+?[0-9]{1,3}[0-9]{9}$", example="+79200000000"),
 *           )
 *       ),
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
