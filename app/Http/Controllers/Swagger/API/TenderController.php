<?php

namespace App\Http\Controllers\Swagger\API;

/**
* @OA\Post(
*     path="/api/tenders",
*     summary="Создать Lot Tender",
*     tags={"Tender"},
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="general_count_transport", type="integer", description="Общее количество транспорта", example=10),
*             @OA\Property(property="price_for_km", type="number", format="float", description="Цена за км", example=5.5),
*             @OA\Property(property="body_volume_for_order", type="number", format="float", description="Объем кузова для заказа", example=50.0),
*             @OA\Property(property="type_transport_weight", type="string", description="**Тип транспортировки по габаритам. Обязательное поле.** small: 1.5-3 тонны, medium: 5 - 10 тонн, large: 10 - 20 тонн, extraLarge: 20 - 40 тонн, superSize: Более 40 тонн", enum={"small", "medium", "large", "extraLarge", "superSize"}, example="small"),
*             @OA\Property(property="type_load_truck", type="string", description="**Тип загрузки грузовика. Обязательное поле. Возможные значения: ftl, ltl, custom.**", enum={"ftl", "ltl", "custom"}, example="ftl"),
*             @OA\Property(property="date_start", type="string", format="date", description="Дата начала", example="2023-10-01"),
*             @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации", example="123e4567-e89b-12d3-a456-426614174000"),
*             @OA\Property(property="period", type="integer", description="Период", example=30),
*             @OA\Property(property="day_period", type="integer", description="Дневной период", example=5),
*             @OA\Property(property="agreement_document", type="string", format="binary", description="Документ соглашения"),
*             @OA\Property(
*                 property="application_document",
*                 type="array",
*                 @OA\Items(type="string", format="binary", description="Документ заявки")
*             ),
*             @OA\Property(
*                 property="specific_date_periods",
*                 type="array",
*                 @OA\Items(
*                     @OA\Property(property="date", type="string", format="date", description="Дата", example="2023-10-01"),
*                     @OA\Property(property="count_transport", type="integer", description="Количество транспорта", example=5)
*                 )
*             )
*         )
*     ),
*     @OA\Response(
*         response=201,
*         description="Успешное создание лота тендера.",
*         @OA\JsonContent(
*             @OA\Property(property="data", ref="#/components/schemas/LotTenderResource"),
*             @OA\Property(property="message", type="string", example="Create lot tender.")
*         )
*     ),
*     @OA\Response(
*         response=400,
*         description="Ошибка при создании лота тендера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Failed to create lot tender."),
*             @OA\Property(property="code", type="integer", example=400)
*         )
*     ),
*     @OA\Response(
*         response=500,
*         description="Общая ошибка сервера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Error server"),
*             @OA\Property(property="code", type="integer", example=500)
*         )
*     )
* ),
*
* @OA\Get(
*     path="/api/tenders",
*     summary="Получить все лоты тендера",
*     tags={"Tender"},
*     @OA\Response(
*         response=200,
*         description="Успешный возврат всех лотов тендера.",
*         @OA\JsonContent(
*             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/LotTenderResource")),
*             @OA\Property(property="message", type="string", example="Return all lot tender.")
*         )
*     ),
*     @OA\Response(
*         response=500,
*         description="Общая ошибка сервера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Error server"),
*             @OA\Property(property="code", type="integer", example=500)
*         )
*     )
* ),
*
* @OA\Get(
*     path="/api/tenders/{lotTender}",
*     summary="Получить лот тендера по UUID",
*     tags={"Tender"},
*     @OA\Parameter(
*         name="lotTender",
*         in="path",
*         required=true,
*         description="UUID лота тендера",
*         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*     ),
*     @OA\Response(
*         response=200,
*         description="Успешный возврат лота тендера.",
*         @OA\JsonContent(
*             @OA\Property(property="data", ref="#/components/schemas/LotTenderResource"),
*             @OA\Property(property="message", type="string", example="Return lot tender.")
*         )
*     ),
*     @OA\Response(
*         response=404,
*         description="Лот тендера не найден.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Lot tender not found."),
*             @OA\Property(property="code", type="integer", example=404)
*         )
*     ),
*     @OA\Response(
*         response=500,
*         description="Общая ошибка сервера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Error server"),
*             @OA\Property(property="code", type="integer", example=500)
*         )
*     )
* ),
*
* @OA\Post(
*     path="/api/tenders/{lotTender}/contractors/{organization}",
*     summary="Добавление исполнителей к заказу",
*     tags={"Tender"},
*     @OA\Parameter(
*         name="lotTender",
*         in="path",
*         required=true,
*         description="UUID лота тендера",
*         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*     ),
*     @OA\Parameter(
*         name="organization",
*         in="path",
*         required=true,
*         description="UUID организации",
*         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="transport_id", type="string", format="uuid", description="UUID транспорта", example="123e4567-e89b-12d3-a456-426614174000"),
*             @OA\Property(property="price_for_km", type="number", format="float", description="Цена за км", example=5.5),
*             @OA\Property(property="comment", type="string", description="Комментарий", example="Комментарий к тендеру")
*         )
*     ),
*     @OA\Response(
*         response=201,
*         description="Успешное добавление исполнителя к заказу.",
*         @OA\JsonContent(
*             @OA\Property(property="data", ref="#/components/schemas/LotTenderResponseResource"),
*             @OA\Property(property="message", type="string", example="Create lot tender response.")
*         )
*     ),
*     @OA\Response(
*         response=400,
*         description="Ошибка при добавлении исполнителя к заказу.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Failed to create lot tender response."),
*             @OA\Property(property="code", type="integer", example=400)
*         )
*     ),
*     @OA\Response(
*         response=500,
*         description="Общая ошибка сервера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Error server"),
*             @OA\Property(property="code", type="integer", example=500)
*         )
*     )
* ),
*
* @OA\Get(
*     path="/api/tenders/{lotTender}/contractors",
*     summary="Вернуть всех исполнителей откликнувшиеся на Тендер",
*     tags={"Tender"},
*     @OA\Parameter(
*         name="lotTender",
*         in="path",
*         required=true,
*         description="UUID лота тендера",
*         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*     ),
*     @OA\Response(
*         response=200,
*         description="Успешный возврат всех исполнителей откликнувшихся на тендер.",
*         @OA\JsonContent(
*             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/LotTenderResponseResource")),
*             @OA\Property(property="message", type="string", example="Return all lot tender Response.")
*         )
*     ),
*     @OA\Response(
*         response=500,
*         description="Общая ошибка сервера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Error server"),
*             @OA\Property(property="code", type="integer", example=500)
*         )
*     )
* ),
*
* @OA\Post(
*     path="/api/tenders/{lotTenderResponse}/agreement-tender",
*     summary="Выбор 'создателем тендера' - перевозчика на выполнение тендера",
*     tags={"Tender"},
*     @OA\Parameter(
*         name="lotTenderResponse",
*         in="path",
*         required=true,
*         description="UUID отклик на лот тендера",
*         @OA\Schema(type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000")
*     ),
*     @OA\RequestBody(
*         required=true,
*         @OA\JsonContent(
*             @OA\Property(property="organization_tender_create_id", type="string", format="uuid", description="UUID организации создателя тендера", example="123e4567-e89b-12d3-a456-426614174000")
*         )
*     ),
*     @OA\Response(
*         response=201,
*         description="Успешное создание соглашения тендера.",
*         @OA\JsonContent(
*             @OA\Property(property="data", ref="#/components/schemas/AgreementTenderResource"),
*             @OA\Property(property="message", type="string", example="Create agreement tender.")
*         )
*     ),
*     @OA\Response(
*         response=400,
*         description="Ошибка при создании соглашения тендера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Failed to create agreement tender."),
*             @OA\Property(property="code", type="integer", example=400)
*         )
*     ),
*     @OA\Response(
*         response=500,
*         description="Общая ошибка сервера.",
*         @OA\JsonContent(
*             @OA\Property(property="message_error", type="string", example="Error server"),
*             @OA\Property(property="code", type="integer", example=500)
*         )
*     )
* ),
*
*
*
*
*
*/
class TenderController
{

}
