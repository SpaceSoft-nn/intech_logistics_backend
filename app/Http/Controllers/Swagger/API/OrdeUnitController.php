<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;



/**
*
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
*               @OA\Property( property="data", type="array", @OA\Items(ref="#/components/schemas/OrderUnitResource") ),
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
* @OA\Get(
*
*      path="/api/orders/{OrderUnit::uuid}",
*      summary="Получить заказ по uuid.",
*      tags={"Order Unit"},
*      @OA\Parameter(
*          name="OrderUnit::uuid",
*          in="path",
*          required=true,
*          description="UUID заказа",
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*      ),
*
*       @OA\Response(
*           response=200,
*           description="Успешный возврат заказа",
*           @OA\JsonContent(
*               @OA\Property(property="data", ref="#/components/schemas/OrderUnitResource", nullable=true),
*               @OA\Property(property="message", type="string", example="Return Order."),
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
*      path="/api/orders/get-schem",
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
*      summary="Создать Заказ (OrderUnit)
*      (если догруз разрешён (ltl) - присылается главный массив адрессов start_address_id/end_address_id (начало/конца) и массив address_array), если тип ftl (без догруза) address_array - опускается",
*      tags={"Order Unit"},
*
*          @OA\RequestBody(
*              required=true,
*              @OA\JsonContent(
*                  allOf={
*                   @OA\Schema(
*                      @OA\Property(property="start_address_id", type="string", format="uuid", description="UUID адреса начала.", example="123e4567-e89b-12d3-a456-426614174000"),
*                      @OA\Property(property="end_address_id", type="string", format="uuid", description="UUID адреса окончания.", example="123e4567-e89b-12d3-a456-426614174000"),
*                      @OA\Property(property="start_date_delivery", type="string", format="date", description="Дата начала заказа.", example="2023-10-01"),
*                      @OA\Property(property="end_date_delivery", type="string", format="date", description="Дата окончания заказа.", example="2023-10-10"),
*                      @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации.", example="123e4567-e89b-12d3-a456-426614174000"),
*                      @OA\Property(property="end_date_order", type="string", format="date", description="Дата окончания заказа.", example="2023-10-15"),
*                      @OA\Property(property="product_type", type="string", maxLength=255, description="Тип продукта (максимум 255 символов).", example="Продукты питания"),
*                      @OA\Property(property="body_volume", type="number", format="float", minimum=1, description="Объём продукта (минимум 1).", example=100.5),
*                      @OA\Property(property="type_load_truck", type="string", enum={"ftl", "ltl", "custom"}, description="Тип загрузки грузовика. Возможные значения: ftl, ltl, custom."),
*                      @OA\Property(property="order_total", type="number", format="float", description="Цена заказа.", example=50000.00),
*                      @OA\Property(property="description", type="string", maxLength=1000, nullable=true, description="Описание (необязательное поле, максимум 1000 символов).", example="Это пример описания заказа."),
*                      @OA\Property(
*                          property="address_array",
*                          type="array",
*                          nullable=true,
*                          description="Массив объектов с UUID адресов в качестве ключей и датами в качестве значений.",
*                          @OA\Items(
*                              type="object",
*                              additionalProperties=@OA\Schema(
*                              type="string",
*                              format="date",
*                             description="Дата в формате 'дд.мм.гггг'.",
*                             example="07.01.2024"
*                           ),
*                           description="Объект с UUID адреса и соответствующей датой."
*                       ),
*                           example={
*                               {
*                                   "9d5b6d75-e26a-419e-96e3-0c0674987e06": "07.01.2024"
*                               },
*                               {
*                               "9d5b6d75-e2eb-42a1-9d67-f767190f1f75": "07.01.2024"
*                               }
*                           }
*                       ),
*                  )
*                 }
*              )
*          ),
*
*       @OA\Response(
*           response=201,
*           description="Успешное создание заказа.",
*           @OA\JsonContent(
*               @OA\Property(property="data", ref="#/components/schemas/OrderUnitResource"),
*               @OA\Property(property="message", type="string", example="Return create Order."),
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
*      path="/api/orders/select-offers",
*      summary="Получить сформированную цену в зависимости от параметров Заказа",
*      tags={"Order Unit"},
*
*       @OA\RequestBody(
*           @OA\JsonContent(
*               allOf={
*                  @OA\Schema(
*                      @OA\Property(property="start_address_id", type="string", format="uuid", description="UUID адреса начала (обязательное поле, должен существовать в таблице addresses).", example="123e4567-e89b-12d3-a456-426614174000"),
 *                     @OA\Property(property="end_address_id", type="string", format="uuid", description="UUID адреса окончания (обязательное поле, должен существовать в таблице addresses).", example="123e4567-e89b-12d3-a456-426614174000"),
 *                     @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации (обязательное поле, должен существовать в таблице organizations).", example="123e4567-e89b-12d3-a456-426614174000"),
 *                     @OA\Property(property="end_date_order", type="string", format="date", description="Дата окончания заказа (обязательное поле).", example="2023-12-31"),
 *                     @OA\Property(property="product_type", type="string", description="Тип продукта (обязательное поле, максимум 255 символов).", example="Продукты питания"),
 *                     @OA\Property(property="body_volume", type="number", format="float", description="Объём продукта (обязательное поле, минимум 1).", example=100.5),
 *                     @OA\Property(property="description", type="string", nullable=true, description="Описание (необязательное поле, максимум 1000 символов).", example="Это пример описания заказа.")
*                  ),
*               },
*           ),
*       ),
*
*       @OA\Response(
*           response=200,
*           description="Успешный возврат сформированный цены, от данных заказа.",
*           @OA\JsonContent(
*               @OA\Property(property="data", ref="#/components/schemas/OrderPriceResource"),
*               @OA\Property(property="message", type="string", example="Return select price."),
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
* @OA\Patch(
*
*      path="/api/orders/{OrderUnit::uuid}",
*      summary="Обновить данные заказа.",
*      description="Обновляет информацию о заказе по UUID",
*      tags={"Order Unit"},
*      @OA\Parameter(
*          name="OrderUnit::uuid",
*          in="path",
*          required=true,
*          description="UUID заказа",
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*      ),
*
*      @OA\RequestBody(
*           @OA\JsonContent(
*               allOf={
*                  @OA\Schema(
*                      @OA\Property(property="change_price", type="boolean", nullable=true, example=false),
*                      @OA\Property(property="change_time", type="boolean", nullable=true, example=true),
*                      @OA\Property(
*                          property="order_status",
*                          type="string",
*                          nullable=true,
*                          enum={
*                              "Опубликован",
*                              "Закрыт",
*                              "Отозван"
*                          },
*                          example="Опубликован"
*                     ),
*                  ),
*               },
*           ),
*       ),
*
*       @OA\Response(
*           response=200,
*           description="Обновление заказа по указанным параметрам, успешно.",
*           @OA\JsonContent(
*               @OA\Property(property="data", type="string", nullable=true, example=null),
*               @OA\Property(property="message", type="string", example="Update order successfully."),
*           ),
*       ),
*
*       @OA\Response(
*           response=404,
*           description="Ошибка обновление заказа.",
*           @OA\JsonContent(
*               @OA\Property(property="data", type="string", nullable=true, example=null),
*               @OA\Property(property="message", type="string", example="Update order error."),
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
*
* @OA\Get(
*
*      path="/api/orders/{OrderUnit::uuid}/contractors",
*      summary="Получить всех подрятчиков откликнувшиеся на заказ",
*      description="Получить всез подрятчиков которые откликнулись на заказ, и заинтересованы в работе, возвращает: organization_order_unit_invoces",
*      tags={"Order Unit"},
*      @OA\Parameter(
*          name="OrderUnit::uuid",
*          in="path",
*          required=true,
*          description="UUID заказа",
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*      ),
*
*
*       @OA\Response(
*         response=200,
*         description="Получение всех подрядчиков успешно.",
*         @OA\JsonContent(
*             @OA\Property(
*                 property="data",
*                 type="array",
*                 @OA\Items(
*                     ref="#/components/schemas/OrgOrderInvoiceResource"
*                 )
*             ),
*             @OA\Property(
*                 property="message",
*                 type="string",
*                 example="Возвращены все подрядчики откликнувшиеся на заказ."
*             )
*         )
*      ),
*
*      @OA\Response(
*           response=500,
*           description="Общая ошибка сервера.",
*           @OA\JsonContent(
*               @OA\Property(property="message_error", type="string", example="Error server"),
*               @OA\Property(property="code", type="integer", example="500"),
*           ),
*      ),
*
* ),
*
* @OA\Post(
*     path="api/orders/{OrderUnit::uuid}/contractors/{organization:uuid}",
*     tags={"Order Unit"},
*     summary="Добавление подрятчика к заказу",
*     description="Добавление подрядчика к заказу",
*     @OA\Parameter(
*          name="OrderUnit::uuid",
*          in="path",
*          description="UUID заказа",
*          required=true,
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*      ),
*     @OA\Parameter(
*          name="organization:uuid",
*          in="path",
*          description="UUID организации - которая будет подрядчиком",
*          required=true,
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*     ),

*     @OA\RequestBody(
*           @OA\JsonContent(
*               allOf={
*                  @OA\Schema(
*                     @OA\Property(
*                         property="price",
*                         type="number",
*                         description="Цена",
*                         example="1000"
*                     ),
*                     @OA\Property(
*                         property="date",
*                         type="string",
*                         description="Дата",
*                         example="2023-03-08"
*                     ),
*                     @OA\Property(
*                         property="comment",
*                         type="string",
*                         description="Комментарий",
*                         example="Комментарий"
*                     ),
*                  ),
*               },
*           ),
*       ),
*
*     @OA\Response(
*          response=200,
*          description="Успешный выбор заказчиком, конкретного подрядчика.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="string", nullable=true, example=null),
*              @OA\Property(property="message", type="string", example="Successfully added a contractor to the order."),
*          ),
*     ),
*
*     @OA\Response(
*          response=404,
*          description="Ошибка выбора конкретного подрядчика, заказчиком",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="string", nullable=true, example=null),
*              @OA\Property(property="message", type="string", example="Error added a contractor to the order."),
*          ),
*     ),
*
*     @OA\Response(
*           response=500,
*           description="Общая ошибка сервера.",
*           @OA\JsonContent(
*               @OA\Property(property="message_error", type="string", example="Error server"),
*               @OA\Property(property="code", type="integer", example="500"),
*           ),
*     ),
*
*
* ),
*
* @OA\Post(
*     path="api/orders/{OrderUnit::uuid}/agreement-order",
*     tags={"Order Unit"},
*     summary="Выбор подрядчика (исполнителя), заказчиком",
*     description="//Заказчик выбирает подрядчика (исполнителя) - *присылает agreement_order_accept с апи",
*     @OA\Parameter(
*          name="OrderUnit::uuid",
*          in="path",
*          description="UUID заказа",
*          required=true,
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*     ),
*
*     @OA\RequestBody(
*           @OA\JsonContent(
*               allOf={
*                  @OA\Schema(
*                     @OA\Property(
*                         property="invoice_cotractor_id",
*                         type="uuid",
*                         description="organization_order_units_invoce - откликнувшиеся подрядчики на заказ",
*                         example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"
*                     ),
*                  ),
*               },
*            ),
*      ),
*
*     @OA\Response(
*          response=200,
*          description="Заказчик успешно выбрал подрятчика, запись создана.",
*          @OA\JsonContent(
*              @OA\Property(
*                 property="data",
*                 type="array",
*                 @OA\Items(
*                     ref="#/components/schemas/AgreementOrderAcceptResource"
*                 )
*              ),
*              @OA\Property(property="message", type="string", example="Заказчик успешно выбрал подрятчика, запись создана."),
*          ),
*     ),
*
*     @OA\Response(
*           response=500,
*           description="Общая ошибка сервера.",
*           @OA\JsonContent(
*               @OA\Property(property="message_error", type="string", example="Error server"),
*               @OA\Property(property="code", type="integer", example="500"),
*           ),
*     ),
*
*
* ),
*
* @OA\patch(

*     path="api/orders/{agreementOrderAccept::uuid}/agreement-accept",
*     tags={"Order Unit"},
*     summary="Утверждения Двух-стороннего договор, о принятии в работу Заказа, со стороны Заказчика/Подрядчика",
*     description="Заказчик/Подрядчик - true/true - что бы была возможность создать Transfer",
*     @OA\Parameter(
*          name="agreementOrderAccept::uuid",
*          in="path",
*          description="uuid записи agreementOrderAccept (двухстороннего договора)",
*          required=true,
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*     ),
*
*     @OA\Response(
*          response=200,
*          description="Заказчик успешно выбрал подрятчика, запись создана.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="string", nullable=true, example=null),
*              @OA\Property(property="message", type="string", example="Заказчик успешно согласовал выполнение заказа."),
*              @OA\Property(property="message2", type="string", example="Подрядчик успешно согласовал выполнение заказа."),
*          ),
*     ),
*
*     @OA\Response(
*           response=500,
*           description="Общая ошибка сервера.",
*           @OA\JsonContent(
*               @OA\Property(property="message_error", type="string", example="Error server"),
*               @OA\Property(property="code", type="integer", example="500"),
*           ),
*     ),
*
*     @OA\Response(
*           response=403,
*           description="У данного пользователя нет прав на согласования заказа.",
*           @OA\JsonContent(
*              @OA\Property(property="data", type="string", nullable=true, example=null),
*              @OA\Property(property="message", type="string", example="У Данного пользователя недостаточно прав, для подтврждения указанного договора agreementOrderAccept::uuid."),
*           ),
*     ),
*
*    security={
*         {"bearerAuth": {}}
*    },
*
* ),
*
*
*/
class OrdeUnitController extends Controller
{

}
