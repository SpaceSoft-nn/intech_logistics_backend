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
*                        @OA\Schema(
*                            @OA\Property(property="start_address_id", type="string", format="uuid", description="**UUID адреса начала. Поле обязательно и должно существовать в таблице addresses.**", example="123e4567-e89b-12d3-a456-426614174000"),
*                            @OA\Property(property="end_address_id", type="string", format="uuid", description="**UUID адреса окончания. Поле обязательно и должно существовать в таблице addresses.**", example="123e4567-e89b-12d3-a456-426614174000"),
*                            @OA\Property(property="start_date_delivery", type="string", format="date", description="**Дата начала заказа. Обязательное поле.**", example="2023-10-01"),
*                            @OA\Property(property="end_date_delivery", type="string", format="date", description="**Дата окончания заказа. Обязательное поле.**", example="2023-10-10"),
*                            @OA\Property(
*                                property="address_array",
*                                type="array",
*                                description="**Массив объектов с UUID адресов и датами (nullable) не обязательное поле - Данное поле предназначеное для промежуточных адрессов погрузки/разгрузки между главным адрессом движение.**",
*                                nullable=true,
*                                @OA\Items(
*                                    type="object",
*                                    @OA\Property(property="id", type="string", format="uuid", description="**UUID адреса. Обязательное поле.**", example="123e4567-e89b-12d3-a456-426614174000"),
*                                    @OA\Property(property="date", type="string", format="date", description="**Дата. Обязательное поле.** - Это дата нужна для указание когда забрать груз", example="2023-10-01"),
*                                    @OA\Property(property="type", type="string", description="**Тип адреса. Обязательное поле. Возможные значения: 'sending' - Аддресс отправка, 'coming' - Адресс прибытия **", enum={"sending", "coming"}, example="sending")
*                                ),
*                            ),
*                            @OA\Property(
*                                property="goods_array",
*                                type="array",
*                                description="Массив объектов, представляющих грузы. Обязательное поле. Минимум 1+ груз",
*                                @OA\Items(
*                                    type="object",
*                                    @OA\Property(property="product_type", type="string", description="**Тип продукта. Обязательное поле.**", example="Тип 1"),
*                                    @OA\Property(property="type_pallet", type="string", description="**Тип поддона. Обязательное поле. Возможные значения: 'eur', 'ecom', 'fin' **", enum={"eur", "ecom", "fin"}, example="eur"),
*                                    @OA\Property(property="cargo_units_count", type="integer", description="**Количество паллетов. Обязательное поле. Минимум 1.**", minimum=1, example=5),
*                                    @OA\Property(property="body_volume", type="number", format="float", description="**Объем кузова. Обязательное поле. Минимум 0.**", minimum=0, example=12.5),
*                                    @OA\Property(property="name_value", type="string", nullable=true, description="**Название. Необязательное поле. Максимум 100 символов.**", maxLength=100, example="Название груза"),
*                                    @OA\Property(property="description", type="string", nullable=true, description="**Описание. Необязательное поле. Максимум 500 символов.**", maxLength=500, example="Описание груза"),
*                                    @OA\Property(property="mgx", type="object", nullable=true, description="**Массогабаритные Характеристики - поле не обязательное, если указано, то будет валидироватья относительно количество паллетов**", ref="#/components/schemas/MgxObject" ),
*                                ),
*                            ),
*                            @OA\Property(property="type_transport_weight", type="string", description="**Тип транспортировки по габаритам. Обязательное поле.** extraSmall: до 0.8 тонны, small: до 1.5 тонны , medium: до 3 тонн, large: до 5 тонн, extraLarge: до 10 тонн, superSize: Более 10 тонн", enum={"extraSmall", "small", "medium", "large", "extraLarge", "superSize"}, example="small"),
*                            @OA\Property(property="organization_id", type="string", format="uuid", description="**UUID организации. Поле обязательно и должно существовать в таблице organizations.**", example="123e4567-e89b-12d3-a456-426614174000"),
*                            @OA\Property(property="end_date_order", type="string", format="date", description="**Дата окончания заказа. Обязательное поле.**", example="2023-10-15"),
*                            @OA\Property(property="type_load_truck", type="string", description="**Тип загрузки грузовика. Обязательное поле. Возможные значения: ftl, ltl, custom.**", enum={"ftl", "ltl", "custom"}, example="ftl"),
*                            @OA\Property(property="order_total", type="number", format="float", description="**Цена заказа. Обязательное поле.**", example=50000.00),
*                            @OA\Property(property="description", nullable=true, type="string", maxLength=1000, nullable=true, description="**Описание (необязательное поле, максимум 1000 символов).**", example="Это пример описания заказа."),
*                      )
*                  }
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
*
*       @OA\Response(
*           response=422,
*           description="**Ошибка валидации данных при указани MGX.** По какому размеру ошибка будет указана в model, new_count_pallet - это сколько нужно паллетов, old_count_pallet - это сколько было указано",
*           @OA\JsonContent(
*               oneOf={
*                   @OA\Schema(
*                        @OA\Property(property="success", type="boolean", example=false),
*                        @OA\Property(
*                            property="info",
*                            type="object",
*                            @OA\Property(property="model", type="string", example="mgx"),
*                            @OA\Property(property="error", type="string", example="height"),
*                            @OA\Property(
*                                property="message",
*                                type="string",
*                                example="Указанные Массогабаритные-Характеристики по максимальной Height у груза: 'ТоварТип', не подходят, максимальная высота: 200, у вас указана: 250."
*                            )
*                        )
*                    ),
*                    @OA\Schema(
*                        @OA\Property(property="success", type="boolean", example=false),
*                        @OA\Property(
*                            property="info",
*                            type="object",
*                            @OA\Property(property="model", type="string", example="mgx"),
*                            @OA\Property(property="error", type="string", example="height"),
*                            @OA\Property(
*                                property="message",
*                                type="string",
*                                example="Указанные Массогабаритные-Характеристики по Height у груза: 'ТоварТип', не подходят под данный тип паллета, максимальная высота для данного типа паллета: 180, у вас указана: 250."
*                            )
*                        )
*                    ),
*                   @OA\Schema(
*                        @OA\Property(property="success", type="boolean", example=false),
*                        @OA\Property(
*                               property="info",
*                               type="object",
*                               @OA\Property(property="model", type="string", example="mgx"),
*                               @OA\Property(property="new_count_pallet", type="string", example="4"),
*                               @OA\Property(property="old_count_pallet", type="string", example="1"),
*                               @OA\Property(property="error", type="string", example="length"),
*                               @OA\Property(
*                                   property="message",
*                                   type="string",
*                                   example="Указанные Массогабаритные-Характеристики по length у груза: 'Молоко', не подходят под указанный тип паллета и указанное количество паллетов. Чтобы груз уместился, укажите количество паллетов: 4, вы указали: 1."
*                               ),
*                        ),
*                   ),
*              }
*           ),
*       ),
*
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
*                     @OA\Property(property="start_address_id", type="string", format="uuid", description="UUID адреса начала (обязательное поле, должен существовать в таблице addresses).", example="123e4567-e89b-12d3-a456-426614174000"),
*                     @OA\Property(property="end_address_id", type="string", format="uuid", description="UUID адреса окончания (обязательное поле, должен существовать в таблице addresses).", example="123e4567-e89b-12d3-a456-426614174000")
*
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
*                                 "draft",
*                                 "published",
*                                 "accepted",
*                                 "in_work",
*                                 "pre_order",
*                                 "completed_and_wait_payment",
*                                 "cancelled",
*                                 "private",
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
*      description="Получить всех подрятчиков которые откликнулись на заказ, и заинтересованы в работе, возвращает: organization_order_unit_invoces",
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
* @OA\Get(
*
*      path="/api/orders/contractors",
*      summary="Получить всех подрятчиков откликнувшиеся на заказ (вне зависимости от заказа - Временный endpoint)",
*      description="Получить всех подрятчиков которые откликнулись на заказ, и заинтересованы в работе, возвращает: organization_order_unit_invoces",
*      tags={"Order Unit"},
*
*      @OA\Response(
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
*          name="orderUnit::uuid",
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
*                         property="transport_id",
*                         type="string",
*                         format="uuid",
*                         description="Идентификатор транспорта организации в формате UUID. Может быть null.",
*                         example="123e4567-e89b-12d3-a456-426614174000"
*                     ),
*                     @OA\Property(
*                         property="price",
*                         type="number",
*                         description="Цена",
*                         nullable=true,
*                         example="1000"
*                     ),
*                     @OA\Property(
*                         property="date",
*                         type="string",
*                         description="Дата",
*                         nullable=true,
*                         example="2023-03-08"
*                     ),
*                     @OA\Property(
*                         property="comment",
*                         type="string",
*                         description="Комментарий",
*                         nullable=true,
*                         example="Комментарий"
*                     ),
*                  ),
*               },
*           ),
*       ),
*
*     @OA\Response(
*          response=201,
*          description="Successfully added a contractor to the order.",
*          @OA\JsonContent(
*              @OA\Property(property="data", ref="#/components/schemas/OrgOrderInvoiceResource"),
*              @OA\Property(property="message", type="string", example="Successfully added a contractor to the order."),
*          ),
*     ),
*
*     @OA\Response(
*          response=404,
*          description="Error added a contractor to the order.",
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
*     path="api/orders/{OrderUnit::uuid}/agreements/agreement-order",
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
*                         property="id_contractor",
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
* @OA\GET(
*     path="api/orders/{OrderUnit::uuid}/agreements/agreement-order",
*     tags={"Order Unit"},
*     summary="Возвращаем AgreementOrder по OrderUnit - uuid (заказу)",
*     description="Возвращаем AgreementOrder по OrderUnit - uuid (заказу)",
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
*     @OA\Response(
*          response=200,
*          description="Заказчик успешно выбрал подрятчика, запись создана.",
*          @OA\JsonContent(
*                @OA\Property( property="data", type="array", @OA\Items(ref="#/components/schemas/AgreementOrderResource") ),
*                @OA\Property(property="message", type="string", example="Записи успешна возвращены."),
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
*
*     path="api/orders/agreements/{agreementOrderAccept::uuid}/agreement-accept",
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
* @OA\Post(
*      path="/api/orders/{orderUnit}/status-transportation",
*      summary="Установка статуса транспортировки для заказа.",
*      tags={"Order Unit"},
*      @OA\Parameter(
*          name="orderUnit",
*          in="path",
*          required=true,
*          description="UUID заказа",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(
*              @OA\Property(
*                  property="status",
*                  type="string",
*                  description="Статус транспортировки",
*                  enum={"transit", "unloading", "loading"},
*                  example="transit"
*              )
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Успешная установка статуса транспортировки.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="null"),
*              @OA\Property(property="message", type="string", example="Set status order transportation event.")
*          )
*      ),
*      @OA\Response(
*          response=404,
*          description="Ошибка установки статуса транспортировки.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="null"),
*              @OA\Property(property="message", type="string", example="Error set status order transportation event.")
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
*
*/
class OrdeUnitController extends Controller
{

}
