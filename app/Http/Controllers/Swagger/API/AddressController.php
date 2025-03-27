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
 *      @OA\RequestBody(
 *          description="Основной JSON-объект, ожидаемый в параметре data - с сервеса Dadata",
 *          required=true,
 *              @OA\JsonContent(
 *                  @OA\Property(
 *                      property="data",
 *                      type="object",
 *                      description="Объект с JSON-структурой, которая приходит с dadata"
 *                  )
 *               )
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
 * @OA\GET(
 *
 *      path="/api/addresses/",
 *      summary="Вернуть запись по id",
 *      tags={"Address"},
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/AddressResource") ),
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
 * ),
 *
 * * @OA\PUT(
 *
 *      path="/api/addresses/",
 *      summary="Обновить адресс полностью (не меняя id)",
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
 *       @OA\RequestBody(
 *          description="Основной JSON-объект, ожидаемый в параметре data - с сервеса Dadata",
 *          required=true,
 *              @OA\JsonContent(
 *                  @OA\Property(
 *                      property="point_name",
 *                      type="string",
 *                      description="Название пункта - вводит сам пользователь"
 *                  ),
 *                  @OA\Property(
 *                      property="unrestricted_value",
 *                      type="string",
 *                      description="Полное название - может автоматически формируется из массива dadata"
 *                  ),
 *                  @OA\Property(
 *                      property="data",
 *                      type="object",
 *                      description="Объект с JSON-структурой, которая приходит с dadata"
 *                  ),
 *               )
 *       ),
 *
 *
 *       @OA\Response(
 *           response=404,
 *           description="Ошибка обновление адресса.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="string", nullable=true, example=null),
 *               @OA\Property(property="message", type="string", example="Update address error."),
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *       ),
 *
 * ),
 */
class AddressController extends Controller
{

}
