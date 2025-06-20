<?php

namespace App\Http\Controllers\Swagger\API;

/**
 * @OA\Get(
 *      path="/api/individual-peoples/drivers",
 *      summary="Получить список водителей в зависимости от роли организации",
 *      tags={"DriverPeople"},
 *      @OA\Parameter(
 *         name="organization_id",
 *         in="header",
 *         required=true,
 *         @OA\Schema(
 *             type="string"
 *         ),
 *         description="Идентификатор организации, который должен быть передан в заголовке"
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Список водителей",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/DriverPeopleResource")),
 *              @OA\Property(property="message", type="string", example="Return all drevirs by organization Customer."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Ошибка сервера",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example=500),
 *          ),
 *      ),
 * ),
 *
 * @OA\Get(
 *      path="/api/individual-peoples/drivers/{driverPeople}",
 *      summary="Получить информацию о конкретном водителе",
 *      tags={"DriverPeople"},
 *      @OA\Parameter(
 *          name="driverPeople",
 *          in="path",
 *          required=true,
 *          description="UUID водителя",
 *          @OA\Schema(
 *              type="string",
 *              format="uuid"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Информация о водителе",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/DriverPeopleResource"),
 *              @OA\Property(property="message", type="string", example="Return driver people for uuid."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Водитель не найден",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Такого водителя не существует."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Ошибка сервера",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example=500),
 *          ),
 *      ),
 * ),
 *
 * @OA\Post(
 *      path="/api/individual-peoples/drivers",
 *      summary="Создать нового водителя",
 *      tags={"DriverPeople"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(property="personal_area_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *              @OA\Property(property="individual_people_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *              @OA\Property(property="organization_id", nullable=true, type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *              @OA\Property(property="series", type="integer", format="int32", example="####"),
 *              @OA\Property(property="number", type="integer", format="int32", example="######"),
 *              @OA\Property(property="date_get", type="string", format="date", example="01.01.2025"),
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Водитель создан",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/DriverPeopleResource"),
 *              @OA\Property(property="message", type="string", example="Create driver people."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Ошибка при создании водителя",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Failed create driver people."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Ошибка сервера",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example=500),
 *          ),
 *      ),
 * ),
 * @OA\Patch(
 *       path="/api/individual-peoples/drivers/{driverPeople}",
 *       summary="Создать новый транспорт.",
 *       tags={"Transports"},
 *       tags={"DriverPeople"},
 *       @OA\Parameter(
 *           name="driverPeople",
 *           in="path",
 *           required=true,
 *           description="UUID водителя",
 *           @OA\Schema(
 *               type="string",
 *               format="uuid"
 *           )
 *       ),
 *       @OA\RequestBody(
 *          required=false,
 *          @OA\JsonContent(
 *              @OA\Property(property="personal_area_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *              @OA\Property(property="individual_people_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *              @OA\Property(property="series", type="integer", format="int32", example="####"),
 *              @OA\Property(property="number", type="integer", format="int32", example="######"),
 *              @OA\Property(property="date_get", type="string", format="date", example="01.01.2025"),
 *          )
 *       ),
 *
 *       @OA\Response(
 *           response=200,
 *           description="Успешное обновление водителя.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", ref="#/components/schemas/DriverPeopleResource"),
 *               @OA\Property(property="message", type="string", example="Успешное обновление водителя."),
 *           ),
 *       ),
 *       @OA\Response(
 *           response=500,
 *           description="Общая ошибка сервера.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error server"),
 *               @OA\Property(property="code", type="integer", example="500"),
 *           ),
 *       ),
 * ),
 *
*/
class DriverPeopleController
{

}
