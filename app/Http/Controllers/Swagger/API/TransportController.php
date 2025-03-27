<?php

namespace App\Http\Controllers\Swagger\API;

/**
 *
 * @OA\Get(
 *      path="/api/transports",
 *      summary="Получить все транспортные средства в зависимости от роли организации",
 *      tags={"Transports"},
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
 *           response=200,
 *           description="Успешный возврат всех транспортов.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TransportResource")),
 *               @OA\Property(property="message", type="string", example="Return all transports by organization Customer."),
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
 * @OA\Post(
 *       path="/api/transports",
 *       summary="Создать новый транспорт.",
 *       tags={"Transports"},
 *       @OA\RequestBody(
 *           required=true,
 *           @OA\JsonContent(
 *               @OA\Property(property="brand_model", type="string", description="Марка и модель", example="Volvo FH"),
 *               @OA\Property(property="year", type="integer", description="Год выпуска транспорта", example=2020),
 *               @OA\Property(property="transport_number", type="string", description="Номерной знак", example=123456),
 *               @OA\Property(property="body_volume", type="float", description="Максимальная Вместимость", example=50),
 *               @OA\Property(property="body_weight", type="float", description="Максимальная Масса груза", example=20),
 *               @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации", example="123e4567-e89b-12d3-a456-426614174000"),
 *               @OA\Property(property="driver_id", type="string", format="uuid", description="UUID водителя", nullable=true, example="123e4567-e89b-12d3-a456-426614174000"),
 *               @OA\Property(property="type_body", ref="#/components/schemas/TransportBodyTypeEnum"),
 *               @OA\Property(property="type_loading", ref="#/components/schemas/TransportLoadingTypeEnum"),
 *               @OA\Property(property="type_status", ref="#/components/schemas/TransportStatusEnum"),
 *               @OA\Property(property="type_weight", ref="#/components/schemas/TransportTypeWeightEnum"),
 *               @OA\Property(property="description", type="string", description="Описание/Заметка", nullable=true, example="Транспорт в хорошем состоянии")
 *           )
 *       ),
 *
 *       @OA\Response(
 *           response=201,
 *           description="Успешное создание транспорта.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", ref="#/components/schemas/TransportResource"),
 *               @OA\Property(property="message", type="string", example="Return create transports."),
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
 * @OA\Get(
 *      path="/api/transports/{transport}",
 *      summary="Получить транспорт по UUID.",
 *      tags={"Transports"},
 *      @OA\Parameter(
 *          name="transport",
 *          in="path",
 *          required=true,
 *          description="UUID транспорта",
 *          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Успешный возврат транспорта.",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/TransportResource"),
 *              @OA\Property(property="message", type="string", example="Return object transport.")
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Транспорт не найден.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Transport not found."),
 *              @OA\Property(property="code", type="integer", example="404")
 *          )
 *      ),
 *      @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Error server"),
 *              @OA\Property(property="code", type="integer", example="500")
 *          )
 *      )
 * ),
 *
 * @OA\Patch(
 *       path="/api/transports/{transport}",
 *       summary="Создать новый транспорт.",
 *       tags={"Transports"},
 *       @OA\Parameter(
 *            name="transport",
 *            in="path",
 *            required=true,
 *            description="UUID транспорта",
 *            @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
 *       ),
 *
 *       @OA\RequestBody(
 *           required=false,
 *           @OA\JsonContent(
 *               @OA\Property(property="brand_model", type="string", description="Марка и модель", example="Volvo FH"),
 *               @OA\Property(property="year", type="integer", description="Год выпуска транспорта", example=2020),
 *               @OA\Property(property="transport_number", type="string", description="Номерной знак", example=123456),
 *               @OA\Property(property="body_volume", type="float", description="Максимальная Вместимость", example=50),
 *               @OA\Property(property="body_weight", type="float", description="Максимальная Масса груза", example=20),
 *               @OA\Property(property="driver_id", type="string", format="uuid", description="UUID водителя", nullable=true, example="123e4567-e89b-12d3-a456-426614174000"),
 *               @OA\Property(property="type_body", ref="#/components/schemas/TransportBodyTypeEnum"),
 *               @OA\Property(property="type_loading", ref="#/components/schemas/TransportLoadingTypeEnum"),
 *               @OA\Property(property="type_status", ref="#/components/schemas/TransportStatusEnum"),
 *               @OA\Property(property="type_weight", ref="#/components/schemas/TransportTypeWeightEnum"),
 *               @OA\Property(property="description", type="string", description="Описание/Заметка", nullable=true, example="Транспорт в хорошем состоянии")
 *           )
 *       ),
 *
 *       @OA\Response(
 *           response=201,
 *           description="Успешное создание транспорта.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", ref="#/components/schemas/TransportResource"),
 *               @OA\Property(property="message", type="string", example="Return create transports."),
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
 *
 *
*/
class TransportController
{

}
