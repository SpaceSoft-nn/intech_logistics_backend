<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
*
* @OA\Get(
*
*      path="/api/transfer",
*      summary="Получить все записи Transfer",
*      tags={"Order Unit"},
*
*       @OA\Response(
*           response=200,
*           description="Успешный возврат Заказов.",
*           @OA\JsonContent(
*               @OA\Property( property="data", type="array", @OA\Items(ref="#/components/schemas/TransferResource") ),
*               @OA\Property(property="message", type="string", example="Return all Transfers."),
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
* @OA\Get(
*
*      path="/api/transfer/{transfer::uuid}",
*      summary="Получить запись по uuid Transfer",
*      tags={"Order Unit"},
*          @OA\Parameter(
*              name="transfer::uuid",
*              in="path",
*              required=true,
*              description="UUID заказа",
*              @OA\Schema(
*                  type="string",
*                  format="uuid"
*              )
*          ),
*
*
*       @OA\Response(
*           response=200,
*           description="Успешный возврат Заказов.",
*           @OA\JsonContent(
*               @OA\Property( property="data", type="array", @OA\Items(ref="#/components/schemas/TransferResource") ),
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
* ),
*
* @OA\Post(
*
*      path="/api/transfer",
*      summary="Создать трансфер по главному заказу или массиву заказов.",
*      tags={"Transfer"},
*
*       @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(
*              allOf={
*                  @OA\Schema(
*                      schema="TransferRequest",
*                      required={
*                          "main_order",
*                          "agreement_order_accept_id",
*                          "transport_id"
*                      },
*                      @OA\Property(
*                          property="main_order",
*                          type="string",
*                          format="uuid",
*                          description="UUID основного заказа - главный заказ или главный вектор движения",
*                          example="123e4567-e89b-12d3-a456-426614174000"
*                      ),
*                      @OA\Property(
*                          property="agreement_order_accept_id",
*                          type="array",
*                          description="Массив UUID соглашений на заказ. Должен содержать как минимум один элемент.",
*                          @OA\Items(
*                              type="string",
*                              format="uuid",
*                              description="UUID соглашения на заказ",
*                              example="123e4567-e89b-12d3-a456-426614174001"
*                          ),
*                          minItems=1
*                      ),
*                      @OA\Property(
*                          property="transport_id",
*                          type="string",
*                          format="uuid",
*                          description="UUID транспорта",
*                          example="123e4567-e89b-12d3-a456-426614174002"
*                      ),
*                      @OA\Property(
*                          property="description",
*                          type="string",
*                          description="Описание трансфера. Необязательно. От 3 до 1000 символов.",
*                          minLength=3,
*                          maxLength=1000,
*                          example="Описание трансфера..."
*                      )
*                  )
*              }
*          )
*      ),
*
*      @OA\Response(
*           response=201,
*           description="Успешное создание Трансфера.",
*           @OA\JsonContent(
*               @OA\Property(property="data", ref="#/components/schemas/TransferResource"),
*               @OA\Property(property="message", type="string", example="Return Transfer."),
*           ),
*       ),
*
*      @OA\Response(
*          response=404,
*          description="Успешное создание Трансфера.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="string", nullable=true, example=null),
*              @OA\Property(property="message", type="string", example="Error create transfer."),
*          ),
*      ),
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
