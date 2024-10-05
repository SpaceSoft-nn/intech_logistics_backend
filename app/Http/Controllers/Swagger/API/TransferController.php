<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
* @OA\Post(
*
*      path="/api/transfer",
*      summary="Создать трансфер по главному заказу и массиву заказов.",
*      tags={"Transfer"},
*
*       @OA\RequestBody(
*           @OA\JsonContent(
*               allOf={
*                  @OA\Schema(
*                      schema="OrderValidation",
*                      required={"main_order", "id_order_array"},
*                          @OA\Property(
*                              property="main_order",
*                              type="string",
*                              format="uuid",
*                              description="UUID основного заказа"
*                          ),
*                          @OA\Property(
*                              property="id_order_array",
*                              type="array",
*                              description="Массив UUID заказов (Сюда нужно добавлять так же основной заказ!)",
*                              @OA\Items(
*                                  type="string",
*                                  format="uuid",
*                                  description="UUID заказа"
*                              )
*                          ),
*                  ),
*              },
*           ),
*       ),
*
*       @OA\Response(
*           response=201,
*           description="Успешное создание Трансфера.",
*           @OA\JsonContent(
*               @OA\Property(property="data", ref="#/components/schemas/TransferResource"),
*               @OA\Property(property="message", type="string", example="Return Transfer."),
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
class TransferController extends Controller
{

}
