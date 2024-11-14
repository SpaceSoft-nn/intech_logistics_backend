<?php

namespace App\Http\Controllers;
/**
*
*
* @OA\Info(
*      title="Payment QR Service API",
*      version="1.0.0"
* ),
* @OA\PathItem(
*      path="/api/swagger"
* ),
*
* @OA\Components(
*     @OA\SecurityScheme(
*         securityScheme="bearerAuth",
*         type="http",
*         scheme="bearer",
*     )
* ),
*
* @OA\Schema(
*    schema="OrderUnitResource",
*    title="Json Ресурс OrderUnit",
*    @OA\Property(property="id", type="string", format="uuid"),
*    @OA\Property(property="end_date_order", type="string", format="date", description="Дата окончания заказа"),
*    @OA\Property(property="body_volume", type="number", format="float", description="Объем кузова"),
*    @OA\Property(property="order_total", type="number", format="float", description="Общая стоимость заказа"),
*    @OA\Property(property="description", type="string", description="Описание заказа"),
*    @OA\Property(property="type_transport_weight", type="number", format="float", description="Вес типа транспорта"),
*    @OA\Property(property="cargo_unit_sum", type="number", format="float", description="Сумма единиц груза"),
*    @OA\Property(property="type_load_truck", type="string", description="Тип загрузочного транспорта"),
*    @OA\Property(
*       property="cargo_goods",
*       type="array",
*       @OA\Items(ref="#/components/schemas/AddressList"),
*       description="Коллекция грузов"
*    ),
*    @OA\Property(
*       property="address_array",
*       type="array",
*       @OA\Items(ref="#/components/schemas/AddressResource"),
*       description="Массив адресов"
*    ),
*    @OA\Property(property="add_load_space", type="boolean", description="Добавление грузового пространства"),
*    @OA\Property(property="change_price", type="boolean", description="Изменение цены"),
*    @OA\Property(property="change_time", type="boolean", description="Изменение времени"),
*    @OA\Property(property="address_is_array", type="boolean", description="Адрес в виде массива"),
*    @OA\Property(property="goods_is_array", type="boolean", description="Товары в виде массива"),
*    @OA\Property(property="order_status", type="string", description="Статус заказа"),
*    @OA\Property(property="user_id", ref="#/components/schemas/UserResource", description="Ресурс пользователя"),
*    @OA\Property(property="organization_id", ref="#/components/schemas/OrganizationResource", description="Ресурс организации"),
* ),
*
*
* @OA\Schema(
*    schema="MGXResource",
*    title="Json Ресурс MGX",
*    @OA\Property(property="length", type="number", format="float", description="Длина, в метрах"),
*    @OA\Property(property="width", type="number", format="float", description="Ширина, в метрах"),
*    @OA\Property(property="height", type="number", format="float", description="Высота, в метрах"),
*    @OA\Property(property="weight", type="number", format="float", description="Вес, в килограммах"),
* ),
*
* //Схема при получении OrderUnitResource
* @OA\Schema(
*     schema="AddressList",
*     type="object",
*     @OA\Property(
*         property="address",
*         ref="#/components/schemas/AddressResource",
*         description="Детальная информация об адресе"
*     ),
*     @OA\Property(property="date", description="Указанная дата у Адресса (Отправки/Прибытия)" , type="enum", format="date", example="2024-01-07"),
*     @OA\Property(property="type", description="(Отправки/Прибытия) - тип у адресса", type="string", enum={"Отправка", "Прибытие"}, example="Прибытие" ),
*     @OA\Property(property="priority", description="Приоритет у Адрессов, приоритет 1 - это всегда главные Адресса (вектор движения)", type="integer", example=1)
* )
*
*
*
* @OA\Schema(
*    schema="CargoGoodResource",
*    title="Json Ресурс Cargo Good - груз",
*    @OA\Property(property="id", type="string", format="uuid"),
*    @OA\Property(property="name_value", type="string", format="date-time"),
*    @OA\Property(property="product_type", type="number", format="float"),
*    @OA\Property(property="type_pallet", type="number", format="float"),
*    @OA\Property(property="cargo_units_count", type="string"),
*    @OA\Property(property="body_volume", type="number", format="float"),
*    @OA\Property(property="description", type="string"),
*    @OA\Property(property="mgx", ref="#/components/schemas/MGXResource")
* ),
*
* @OA\Schema(
*     schema="MgxObject",
*     required={"length", "width", "height", "weight"},
*     @OA\Property(property="length", type="number", format="float", description="Длина. Обязательное поле длины. Минимум 0.", minimum=0, example=10.0),
*     @OA\Property(property="width", type="number", format="float", description="Ширина. Обязательное поле ширины. Минимум 0.", minimum=0, example=5.0),
*     @OA\Property(property="height", type="number", format="float", description="Высота. Обязательное поле высоты. Минимум 0.", minimum=0, example=20.0),
*     @OA\Property(property="weight", type="number", format="float", description="Вес. Обязательное поле веса. Минимум 0.", minimum=0, example=15.0),
* )
*
* @OA\Schema(
*   schema="MatrixDistanceResource",
*   title="Matrix Distance Resource",
*   @OA\Property(property="city_start_gar_id", type="string", format="uuid", description="ID города отправления"),
*   @OA\Property(property="city_end_gar_id", type="string", format="uuid", description="ID города назначения"),
*   @OA\Property(property="city_name_start", type="string", description="Название города отправления"),
*   @OA\Property(property="city_name_end", type="string", description="Название города назначения"),
*   @OA\Property(property="distance", type="number", format="float", description="Расстояние между городами в километрах"),
* ),
*
* @OA\Schema(
*   schema="RegionEconomicFactorResource",
*   title="Ресурс региона",
*   @OA\Property(property="id", type="string", format="uuid", description="Уникальный идентификатор региона (UUID)"),
*   @OA\Property(property="region_start_gar_id", type="string", format="uuid", description="Значение Гар для области отправления (UUID)"),
*   @OA\Property(property="region_end_gar_id", type="string", format="uuid", description="Значение Гар для области прибытия (UUID)"),
*   @OA\Property(property="region_name_start", type="string", description="Название области отправления"),
*   @OA\Property(property="region_name_end", type="string", description="Название области прибытия"),
*   @OA\Property(property="factor", type="number", format="float", description="Коэффициент"),
*   @OA\Property(property="price", type="string", format="decimal", description="Цена за 1 км", example="123.45"),
* ),
*
* @OA\Schema(
*   schema="OrganizationResource",
*   title="Организация",
*   description="Информация об организации",
*
*   @OA\Property(property="name", type="string", description="Название организации", maxLength=101, minLength=2),
*   @OA\Property(property="address", type="string", description="Адрес организации", maxLength=255, minLength=12),
*   @OA\Property(property="phone", type="string", description="Телефон организации"),
*   @OA\Property(property="email", type="string", format="email", description="Email организации", maxLength=100),
*   @OA\Property(property="website", type="string", description="Вебсайт организации"),
*   @OA\Property(
*     property="type",
*     type="string",
*     description="Тип организации",
*     enum={"ooo", "ie"}
*   ),
*   @OA\Property(property="description", type="string", nullable=true, description="Описание организации"),
*   @OA\Property(property="industry", type="string", nullable=true, description="Индустрия организации"),
*   @OA\Property(property="founded_date", type="string", format="date", nullable=true, description="Дата основания организации"),
*   @OA\Property(property="inn", type="string", description="ИНН организации", pattern="^(([0-9]{12})|([0-9]{10}))?$"),
*   @OA\Property(
*     property="type_cabinet",
*     type="string",
*     description="Тип кабинета",
*     enum={"Заказчик", "Склад", "Перевозчик"}
*   ),
*   @OA\Property(
*     property="kpp",
*     type="string",
*     description="КПП (для ООО)",
*     pattern="^([0-9]{9})?$",
*     nullable=true
*   ),
*   @OA\Property(
*     property="registration_number",
*     type="string",
*     description="ОГРН (для ООО)",
*     pattern="^([0-9]{13})?$",
*     nullable=true
*   ),
*   @OA\Property(
*     property="registration_number_individual",
*     type="string",
*     description="ОГРНИП (для ИП)",
*     pattern="^\d{15}$",
*     nullable=true
*   ),
* ),
*
* @OA\Schema(
*    schema="OrderPriceResource",
*    description="Json ресурс методов погрузки грузовика с ценами",
*    title="Loading Truck Methods",
*    @OA\Property(
*        property="FTL",
*        type="object",
*        @OA\Property(property="value", type="string", description="Значение метода FTL"),
*        @OA\Property(property="price", type="integer", description="Цена метода FTL")
*    ),
*    @OA\Property(
*        property="LTL",
*        type="object",
*        @OA\Property(property="value", type="string", description="Значение метода LTL"),
*        @OA\Property(property="price", type="integer", description="Цена метода LTL")
*    )
* ),
*
*
* @OA\Schema(
*     schema="InvoiceOrderResource",
*     description="JSON ресурс с информацией о ресурсе",
*     title="Your Resource",
*     @OA\Property(property="id", type="string", format="uuid", description="Уникальный идентификатор ресурса", example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"),
*     @OA\Property(property="price", type="number", format="float", description="Цена ресурса", example=100000),
*     @OA\Property(property="date", type="string", format="date", description="Дата ресурса", example="2024-10-31"),
*     @OA\Property(property="comment", type="string", description="Текст комментария", example="Это комментарий от Подрядчика")
* ),
*
* @OA\Schema(
*     schema="OrgOrderInvoiceResource",
*     title="Organization Order Invoice Resource",
*     description="JSON ресурс - который отвечает за то, какой Подрядчик откликнулся на определённый заказ (с invoice_order (неким документом или информацией))",
*     type="object",
*     @OA\Property(property="id", type="string", format="uuid", example="3fa85f64-5717-4562-b3fc-2c963f66afa6"),
*     @OA\Property(property="organization_contract", type="object", nullable=true, ref="#/components/schemas/OrganizationResource"),
*     @OA\Property(property="order", type="object", nullable=true, ref="#/components/schemas/OrderUnitResource"),
*     @OA\Property(property="invoice_order", type="object", nullable=true, ref="#/components/schemas/InvoiceOrderResource")
* ),
*
*
* @OA\Schema(
*     schema="AgreementOrderAcceptResource",
*     description="JSON ресурс (agreement_order_accept) - статус утверждения двухстороннего договора Заказчик/Исполнитель",
*     title="Agreement Order Accept Resource",
*     @OA\Property(
*         property="id",
*         type="string",
*         format="uuid",
*         description="Уникальный идентификатор ресурса",
*         example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"
*     ),
*     @OA\Property(
*         property="agreement_order",
*         type="object",
*         description="Данные о заказе",
*         @OA\Property(
*             property="order_unit_id",
*             type="string",
*             format="uuid",
*             description="Идентификатор подразделения заказа",
*             example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"
*         ),
*         @OA\Property(
*             property="organization_contractor_id",
*             type="string",
*             format="uuid",
*             description="Идентификатор организации Подрядчика",
*             example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"
*         ),
*         @OA\Property(
*             property="organization_order_units_invoce_id",
*             type="string",
*             format="uuid",
*             description="Идентификатор откликнувшегося подрядчика на заказ",
*             example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"
*         )
*     ),
*     @OA\Property(
*         property="order_bool",
*         type="boolean",
*         description="Статус утверждения со стороны Заказчика",
*         example=true
*     ),
*     @OA\Property(
*         property="contractor_bool",
*         type="boolean",
*         description="Статус утверждения со стороны Исполнителя",
*         example=true
*     )
* ),
*
*
*
* @OA\Schema(
*     schema="TransferResource",
*     description="JSON ресурс - информация о перевозке, которая согласована к работе (может состоять из одного заказа или множества)",
*     title="Transfer",
*     @OA\Property(property="transport_id", type="string", format="uuid", description="ID транспорта"),
*     @OA\Property(property="delivery_start", type="string", description="Начало доставки"),
*     @OA\Property(property="delivery_end", type="string", description="Конец доставки"),
*     @OA\Property(property="Address_start_id", type="object", format="uuid", description="Адрес начала доставки"),
*     @OA\Property(property="Address_end_id", type="string", format="uuid", description="Адрес конца доставки"),
*     @OA\Property(property="order_total", type="integer", description="Общая сумма заказа"),
*     @OA\Property(property="description", type="string", description="Описание заказа"),
*     @OA\Property(property="body_volume", type="integer", description="Объем кузова")
* ),
*
*
* @OA\Schema(
*     schema="AddressResource",
*     description="Json ресурс адресса",
*     title="Address",
*     @OA\Property(property="id", type="string", format="uuid", description="ID адреса"),
*     @OA\Property(property="region", type="string", description="Регион адреса"),
*     @OA\Property(property="city", type="string", description="Город адреса"),
*     @OA\Property(property="street", type="string", description="Улица адреса"),
*     @OA\Property(property="building", type="string", description="Дом адреса", nullable=true),
*     @OA\Property(property="apartament", type="string", description="Квартира адреса", nullable=true),
*     @OA\Property(property="house_number", type="string", description="Номер дома адреса", nullable=true),
*     @OA\Property(property="postal_code", type="string", description="Почтовый индекс адреса", nullable=true),
*     @OA\Property(property="type_Address", type="string", description="Тип адреса", nullable=true),
*     @OA\Property(property="latitude", type="float", description="Широта адреса"),
*     @OA\Property(property="longitude", type="float", description="Долгота адреса")
* ),
*
*/
abstract class Controller
{
    //
}
