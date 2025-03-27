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
*              @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации, должен существовать в таблице organizations", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="add_load_space", type="boolean", description="Дополнительное место для загрузки", nullable=true, example=true),
*              @OA\Property(property="road_back", type="boolean", description="Обратная дорога", nullable=true, example=false),
*              @OA\Property(property="directly_road", type="boolean", description="Прямая дорога", nullable=true, example=true),
*              @OA\Property(property="description", type="string", description="Описание", nullable=true, maxLength=1000, example="Описание маршрута"),
*              @OA\Property(property="status", type="enum", ref="#/components/schemas/OfferContractorStatusEnum"),
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
* @OA\Post(
*      path="/api/offer-contractors/{offerContractor}/customer/{organization}",
*      summary="Организация - заказчик - откликается на предложения перевозчика.",
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
*              @OA\Property(property="type_load_truck", ref="#/components/schemas/TypeLoadingTruckMethodEnum"),
*              @OA\Property(property="type_transport_weight", ref="#/components/schemas/TransportTypeWeightEnum"),
*              @OA\Property(property="start_address_id", type="string", format="uuid", description="UUID начального адреса, должен существовать в таблице addresses", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="end_address_id", type="string", format="uuid", description="UUID конечного адреса, должен существовать в таблице addresses", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="start_date", type="string", format="date", description="Дата начала", example="2023-12-01"),
*              @OA\Property(property="end_date", type="string", format="date", description="Дата завершения", example="2023-12-05"),
*              @OA\Property(property="description", type="string", description="Описание заказа", nullable=true, maxLength=1000, example="Доставка из Москвы в Санкт-Петербург"),
*              @OA\Property(
*                  property="goods_array",
*                  type="array",
*                  description="Массив объектов, представляющих грузы. Обязательное поле. Минимум 1+ груз",
*                  @OA\Items(
*                      type="object",
*                      @OA\Property(property="product_type", type="string", description="**Тип продукта. Обязательное поле.**", example="Тип 1"),
*                      @OA\Property(property="type_pallet", type="string", description="**Тип поддона. Обязательное поле. Возможные значения: 'eur', 'ecom', 'fin' **", enum={"eur", "ecom", "fin"}, example="eur"),
*                      @OA\Property(property="cargo_units_count", type="integer", description="**Количество паллетов. Обязательное поле. Минимум 1.**", minimum=1, example=5),
*                      @OA\Property(property="body_volume", type="number", format="float", description="**Объем кузова. Обязательное поле. Минимум 0.**", minimum=0, example=12.5),
*                      @OA\Property(property="name_value", type="string", nullable=true, description="**Название. Необязательное поле. Максимум 100 символов.**", maxLength=100, example="Название груза"),
*                      @OA\Property(property="description", type="string", nullable=true, description="**Описание. Необязательное поле. Максимум 500 символов.**", maxLength=500, example="Описание груза"),
*                      @OA\Property(property="mgx", type="object", nullable=true, description="**Массогабаритные Характеристики - поле не обязательное, если указано, то будет валидироватья относительно количество паллетов**", ref="#/components/schemas/MgxObject" ),
*                  ),
*              ),
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
*      path="/api/offer-contractors/{offerContractor}/customer",
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
* @OA\Post(
*      path="/api/offer-contractors/{offerContractor}/agreements",
*      summary="Выбрать организацию заказчика на исполнение предложения.",
*      tags={"Offer Contractor"},
*      @OA\Parameter(
*          name="offerContractor",
*          in="path",
*          required=true,
*          description="ID предложения от Перевозчика",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(
*              @OA\Property(property="offer_contractor_customer_id", type="string", format="uuid", description="UUID отклика заказчика, должен существовать в таблице offer_contractor_invoice_order_customers", example="123e4567-e89b-12d3-a456-426614174000")
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Организация заказчика успешно выбрана на исполнение предложения.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="object", ref="#/components/schemas/AgreementOrderContractorResource"),
*              @OA\Property(property="message", type="string", example="Организация заказчика успешно выбрана на исполнение предложения.")
*          )
*      ),
*      @OA\Response(
*          response=422,
*          description="Ошибка валидации",
*          @OA\JsonContent(
*               type="object",
*               required={"success", "info"},
*               @OA\Property(
*                   property="success",
*                   type="boolean",
*                   example=false
*               ),
*               @OA\Property(
*                   property="info",
*                   type="string",
*                   enum={
*                       "Организация заказчика уже была выбрана для этого предложения.",
*                       "Перевозчик для этого предложения уже выбрал организацию-заказчика."
*                   },
*                   example="Организация заказчика уже была выбрана для этого предложения.",
*               ),
*          ),
*          )
*      ),
*      @OA\Response(
*          response=500,
*          description="Общая ошибка сервера.",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Error server"),
*              @OA\Property(property="code", type="integer", example="500")
*          )
*      ),
* ),
*
* @OA\Get(
*      path="/api/offer-contractors/{offerContractor}/agreements",
*      summary="Вернуть подтверждённую заявку (выбранная организация - заказчика на исполнение) по предложению (если имеется).",
*      tags={"Offer Contractor"},
*      @OA\Parameter(
*          name="offerContractor",
*          in="path",
*          required=true,
*          description="ID предложения от Перевозчика",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\Response(
*          response=200,
*          description="Возврат записи о назначенном исполнителе в лице организации заказчика, по предложению перевозчика.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="object", nullable=true, ref="#/components/schemas/AgreementOrderContractorResource"),
*              @OA\Property(property="message", type="string", example="Возвратили запись о назначенном исполнителе в лице организации заказчика, по предложению перевозчика.")
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
*      path="/api/offer-contractors/{agreementOrderContractorAccept}/accept",
*      summary="Утверждение двухстороннего договора о принятии в работу предложения и принятии заказа.",
*      tags={"Offer Contractor"},
*      @OA\Parameter(
*          name="agreementOrderContractorAccept",
*          in="path",
*          required=true,
*          description="ID принятия соглашения заказа подрядчика",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\Response(
*          response=200,
*          description="Успешное подтверждение с двух сторон.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="object", ref="#/components/schemas/AgreementOrderContractorAcceptResource"),
*              @OA\Property(property="message", type="string", example="Успешное подтверждение с двух сторон.")
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
*      path="/api/offer-contractors/{offerContractor}",
*      summary="Обновление предложения перевозчика.",
*      tags={"Offer Contractor"},
*      @OA\Parameter(
*          name="agreementOrderContractorAccept",
*          in="path",
*          required=true,
*          description="ID Предложения перевозчика",
*          @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*      ),
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(
*              @OA\Property(property="city_name_start", type="string", description="Название начального города", example="Москва", minLength=2),
*              @OA\Property(property="city_name_end", type="string", description="Название конечного города", example="Санкт-Петербург", minLength=2),
*              @OA\Property(property="price_for_distance", type="number", format="float", description="Цена за расстояние", example=1500.50),
*              @OA\Property(property="transport_id", type="string", format="uuid", description="UUID транспорта, должен существовать в таблице transports", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="add_load_space", type="boolean", description="Дополнительное место для загрузки", nullable=true, example=true),
*              @OA\Property(property="road_back", type="boolean", description="Обратная дорога", nullable=true, example=false),
*              @OA\Property(property="directly_road", type="boolean", description="Прямая дорога", nullable=true, example=true),
*              @OA\Property(property="description", type="string", description="Описание", nullable=true, maxLength=1000, example="Описание маршрута"),
*              @OA\Property(property="status", type="enum", ref="#/components/schemas/OfferContractorStatusEnum"),
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Успешное подтверждение с двух сторон.",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="object", ref="#/components/schemas/AgreementOrderContractorAcceptResource"),
*              @OA\Property(property="message", type="string", example="Успешное подтверждение с двух сторон.")
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
class OfferContractor
{

}
