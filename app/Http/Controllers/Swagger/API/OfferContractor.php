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
*/
class OfferContractor
{

}
