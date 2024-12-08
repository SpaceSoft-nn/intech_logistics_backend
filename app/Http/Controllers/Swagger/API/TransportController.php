<?php

namespace App\Http\Controllers\Swagger\API;


/**
*
* @OA\Get(
*      path="/api/transports",
*      summary="Получить все доступные transports из таблицы.",
*      tags={"Offer Contractor"},
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
*/
class TransportController
{

}
