<?php

namespace App\Http\Controllers\Swagger\API;


/**
*
* @OA\Get(
*      path="/api/transports",
*      summary="Получить все доступные transports из таблицы.",
*      tags={"Transports"},
*       @OA\Response(
*           response=200,
*           description="Успешный возврат всех транспортов.",
*           @OA\JsonContent(
*               @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/TransportResource")),
*               @OA\Property(property="message", type="string", example="Return transports all."),
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
*               @OA\Property(property="type", type="string", description="Тип транспортного средства", enum={"car", "semitruck", "truck", "container"}, example="semitruck"),
*               @OA\Property(property="brand_model", type="string", description="Марка и модель", example="Volvo FH"),
*               @OA\Property(property="year", type="integer", description="Год выпуска транспорта", example=2020),
*               @OA\Property(property="transport_number", type="string", description="Номерной знак", example=123456),
*               @OA\Property(property="body_volume", type="integer", description="Максимальная Вместимость", example=50),
*               @OA\Property(property="body_weight", type="integer", description="Максимальная Масса груза", example=20),
*               @OA\Property(property="type_status", type="string", description="Текущий статус транспортного средства", enum={"free", "work", "repair"}, example="free"),
*               @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации", example="123e4567-e89b-12d3-a456-426614174000"),
*               @OA\Property(property="driver_id", type="string", format="uuid", description="UUID водителя", nullable=true, example="123e4567-e89b-12d3-a456-426614174000"),
*               @OA\Property(property="description", type="string", description="Описание/Заметка", nullable=true, example="Транспорт в хорошем состоянии")
*           )
*       ),

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
*/
class TransportController
{

}
