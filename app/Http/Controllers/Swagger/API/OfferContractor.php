<?php

namespace App\Http\Controllers\Swagger\API;


/**
*
* @OA\Get(
*      path="/api/offer-contractors",
*      summary="Получить всех подрядчиков.",
*      tags={"Offer Contractor"},
*       @OA\Response(
*           response=200,
*           description="Успешный возврат подрядчиков.",
*           @OA\JsonContent(
*               @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/OfferContractorResource")),
*               @OA\Property(property="message", type="string", example="Return create offer contractors."),
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
*      path="/api/offer-contractors",
*      summary="Создать подрядчика.",
*      tags={"Offer Contractor"},
*      @OA\RequestBody(
*      required=true,
*      @OA\JsonContent(
*              @OA\Property(property="city_name_start", type="string", description="Название начального города", example="Москва", minLength=2),
*              @OA\Property(property="city_name_end", type="string", description="Название конечного города", example="Санкт-Петербург", minLength=2),
*              @OA\Property(property="price_for_distance", type="number", format="float", description="Цена за расстояние", example=1500.50),
*              @OA\Property(property="transport_id", type="string", format="uuid", description="UUID транспорта, должен существовать в таблице transports", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="user_id", type="string", format="uuid", description="UUID пользователя, должен существовать в таблице users", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации, должен существовать в таблице organizations", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="add_load_space", type="boolean", description="Дополнительное место для загрузки", nullable=true, example=true),
*              @OA\Property(property="road_back", type="boolean", description="Обратная дорога", nullable=true, example=false),
*              @OA\Property(property="directly_road", type="boolean", description="Прямая дорога", nullable=true, example=true),
*              @OA\Property(property="description", type="string", description="Описание", nullable=true, maxLength=1000, example="Описание маршрута")
*          )
*      ),
*
*       @OA\Response(
*           response=201,
*           description="Успешное создание подрядчика.",
*           @OA\JsonContent(
*               @OA\Property(property="data", ref="#/components/schemas/OfferContractorResource"),
*               @OA\Property(property="message", type="string", example="Return create offer contractor."),
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
*   @OA\Post(
*      path="/api/{offerContractor}/customer/{organization}",
*      summary="Добавить заказ для клиента.",
*      tags={"Offer Contractor"},
*      @OA\Parameter(
*          name="offerContractor",
*          in="path",
*          required=true,
*          description="ID предложения от Перевозчика",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\Parameter(
*          name="organization",
*          in="path",
*          required=true,
*          description="ID организации - заказчика (кто откликнулся на заказ)",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(
*              @OA\Property(property="order_total", type="number", format="float", description="Общая стоимость заказа", example=2000.50),
*              @OA\Property(property="body_volume", type="number", format="float", description="Объем кузова", example=15.5),
*              @OA\Property(property="type_product", type="string", description="Тип продукта", maxLength=255, example="Товары народного потребления"),
*              @OA\Property(property="type_load_truck", ref="#/components/schemas/TransportStatusEnum"),
*              @OA\Property(property="type_transport_weight", ref="#/components/schemas/TransportTypeWeightEnum"),
*              @OA\Property(property="start_address_id", type="string", format="uuid", description="UUID начального адреса, должен существовать в таблице addresses", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="end_address_id", type="string", format="uuid", description="UUID конечного адреса, должен существовать в таблице addresses", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="start_date", type="string", format="date", description="Дата начала", example="2023-12-01"),
*              @OA\Property(property="end_date", type="string", format="date", description="Дата завершения", example="2023-12-05"),
*              @OA\Property(property="description", type="string", description="Описание заказа", nullable=true, maxLength=1000, example="Доставка из Москвы в Санкт-Петербург")
*          )
*      ),
*      @OA\Response(
*          response=201,
*          description="Успешное добавление клиента к подрядчику.",
*          @OA\JsonContent(
*              @OA\Property(property="data", ref="#/components/schemas/OfferContractorCustomerResource"),
*              @OA\Property(property="message", type="string", example="Customer added to offer contractor successfully."),
*          ),
*      ),
*
*      @OA\Response(
*         response=422,
*         description="Данная организация уже откликнулась на это предложения.",
*         @OA\JsonContent(
*             type="object",
*             @OA\Property(property="success", type="boolean", example=false, description="Флаг успешного выполнения"),
*             @OA\Property(property="info", type="string", example="Данная организация уже откликнулась на это предложения.", description="Сообщение об ошибке")
*         )
*      ),
*
*      @OA\Response(
*          response=500,
*          description="Общая ошибка сервера.",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Error server"),
*              @OA\Property(property="code", type="integer", example="500"),
*          )
*      ),
* ),
*
*
*
* @OA\Get(
*      path="/api/{offerContractor}/customer",
*      summary="Получить все отклики у предложения перевозчика.",
*      tags={"Offer Contractor"},
*      @OA\Parameter(
*          name="offerContractor",
*          in="path",
*          required=true,
*          description="ID предложения перевозчика",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\Response(
*          response=201,
*          description="Возврат всех откликов по предложению.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/OfferContractorCustomerResource")),
*              @OA\Property(property="message", type="string", example="Возврат всех откликов по предложению."),
*          ),
*      ),
*
*      @OA\Response(
*          response=500,
*          description="Общая ошибка сервера.",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Error server"),
*              @OA\Property(property="code", type="integer", example="500"),
*          )
*      )
* ),
*
*/
class OfferContractor
{

}
