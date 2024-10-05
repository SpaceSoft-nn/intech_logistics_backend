<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;



/**
* @OA\Get(
*
*      path="/api/orders",
*      summary="Получить все готовы заказы.",
*      tags={"Order Unit"},
*
*       @OA\Response(
*           response=200,
*           description="Успешное задания Трансфера.",
*           @OA\JsonContent(
*               @OA\Property(property="data", ref="#/components/schemas/OrderUnitResource"),
*               @OA\Property(property="message", type="string", example="Return Orders."),
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
* )
*/
class OrdeUnitController extends Controller
{

}
