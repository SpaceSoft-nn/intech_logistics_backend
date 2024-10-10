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
*           description="Успешный возврат Заказов.",
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
* ),
*
* @OA\Post(
*
*      path="/api/orders/algorithm",
*      summary="Получить все заказы которые входят в вектор движения Главного заказа",
*      tags={"Order Unit"},
*
*       @OA\RequestBody(
*           @OA\JsonContent(
*               allOf={
*                  @OA\Schema(
*                      @OA\Property(
*                          property="main_order",
*                          type="string",
*                          format="uuid",
*                          description="ID основного заказа, обязательное поле",
*                          example="550e8400-e29b-41d4-a716-446655440000"
*                      ),
*                      @OA\Property(
*                          property="search_distance",
*                          type="integer",
*                          description="Расстояние для поиска, необязательное поле - по стандарту стоит 100 км (Поиска) - (Указывать в Километрах)",
*                          example=10
*                      ),
*                 ),
*               },
*           ),
*       ),
*
*       @OA\Response(
*           response=200,
*           description="Успешный возврат заказов входящие в область.",
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
* ),
*
* @OA\Post(
*
*      path="/api/orders",
*      summary="Создать Заказ (OrderUnit) (Прислать только адресса отправки и прибытия, остальное будет заполнено случайно)",
*      tags={"Order Unit"},
*
*       @OA\RequestBody(
*           @OA\JsonContent(
*               allOf={
*                  @OA\Schema(
*                      @OA\Property(property="start_adress_id", type="string", format="uuid", description="uuid записи", example="123e4567-e89b-12d3-a456-426614174000"),
*                      @OA\Property(property="end_adress_id", type="string", format="uuid", description="uuid записи", example="123e4567-e89b-12d3-a456-426614174000"),
*                  ),
*               },
*           ),
*       ),
*
*       @OA\Response(
*           response=200,
*           description="Успешное возврат созданного Заказа.",
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
* ),
*
*/
class OrdeUnitController extends Controller
{

}
