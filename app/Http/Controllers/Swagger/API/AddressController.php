<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\POST(
 *
 *      path="/api/addresses",
 *      summary="Создать запись Address",
 *      tags={"Address"},
 *
 *       @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                    @OA\Property(property="region", type="string", description="Регион", example="Москва"),
*                         @OA\Property(property="city", type="string", description="Город", example="Москва"),
*                         @OA\Property(property="street", type="string", description="Улица", example="Тверская"),
*                         @OA\Property(property="building", type="string", description="Строение", nullable=true, example="1"),
*                         @OA\Property(property="apartment", type="string", description="Квартира", nullable=true, example="101"),
*                         @OA\Property(property="house_number", type="string", description="Номер дома", nullable=true, example="10"),
*                         @OA\Property(property="postal_code", type="string", description="Почтовый индекс", nullable=true, example="123456"),
*                         @OA\Property(property="latitude", type="string", description="Широта", example="55.7558"),
*                         @OA\Property(property="longitude", type="string", description="Долгота", example="37.6173"),
 *                 )
 *              },
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property( property="data", type="object", ref="#/components/schemas/AddressResource" ),
*               @OA\Property(property="message", type="string", example="Return Address create."),
 *          ),
 *      ),
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
 * ),
 *
 * @OA\GET(
 *
 *      path="/api/addresses/{address::uuid}",
 *      summary="Вернуть запись по id",
 *      tags={"Address"},
 *      @OA\Parameter(
 *              name="address::uuid",
 *              in="path",
 *              required=true,
 *              description="UUID Адресса",
 *              @OA\Schema(
 *                  type="string",
 *                  format="uuid"
 *              )
 *       ),
 *
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property( property="data", type="object", ref="#/components/schemas/AddressResource" ),
 *              @OA\Property(property="message", type="string", example="Return Address select."),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Адресс не найден.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Такого адресса не существует."),
 *          ),
 *      ),
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
 * ),
 *
 * * @OA\GET(
 *
 *      path="/api/addresses/",
 *      summary="Вернуть запись по id",
 *      tags={"Address"},
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property( property="data", type="object", @OA\Items(ref="#/components/schemas/AddressResource") ),
 *              @OA\Property(property="message", type="string", example="Return Address select."),
 *          ),
 *      ),
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
class AddressController extends Controller
{

}
