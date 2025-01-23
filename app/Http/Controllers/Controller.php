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
*    @OA\Property(property="number", type="integer", format="int32", description="Номер заказа для вывода на фронт"),
*    @OA\Property(property="end_date_order", type="string", format="date", description="Дата окончания заказа"),
*    @OA\Property(property="exemplary_date_start", nullable=true, type="string", format="date", description="Дата 'примерного' начала заказа"),
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
*    @OA\Property(property="transportation_status", type="string", description="Статус заказа при транспортировки: В пути, На разгрузке..."),
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
* @OA\Schema(
*     schema="InvoiceOrderCustomerResource",
*     type="object",
*     title="Invoice Order Customer Resource",
*     description="Ресурс для вывода данных о заказе клиента",
*     @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
*     @OA\Property(property="order_total", type="string", description="Цена/Выплата за заказ", example="2500.75"),
*     @OA\Property(property="description", type="string", nullable=true, description="Описание заказа", example="Доставка продуктов питания"),
*     @OA\Property(property="body_volume", type="string", description="Общий объем заказа", example="15.5"),
*     @OA\Property(property="type_product", type="string", description="Тип товара перевозки", example="Электроника"),
*     @OA\Property(property="type_transport_weight", type="string", description="Тип транспортного средства", example="medium"),
*     @OA\Property(property="type_load_truck", type="string", description="Тип загрузки трака", example="LTL"),
*     @OA\Property(property="start_address_id", type="string", format="uuid", description="ID адреса начала заказа", example="123e4567-e89b-12d3-a456-426614174000"),
*     @OA\Property(property="end_address_id", type="string", format="uuid", description="ID адреса доставки", example="123e4567-e89b-12d3-a456-426614174001"),
*     @OA\Property(property="start_date", type="string", format="date", description="Дата отправления", example="2023-12-01"),
*     @OA\Property(property="end_date", type="string", format="date", description="Дата прибытия", example="2023-12-05"),
*
* ),
*
* @OA\Schema(
*     schema="OfferContractorResource",
*     type="object",
*     title="Offer Contractor Resource",
*     properties={
*         @OA\Property(property="id", type="string", format="uuid", example="123e4567-e89b-12d3-a321-426614198000"),
*         @OA\Property(property="city_name_start", type="string", description="Название начального города", example="Москва", minLength=2),
*         @OA\Property(property="city_name_end", type="string", description="Название конечного города", example="Санкт-Петербург", minLength=2),
*         @OA\Property(property="price_for_distance", type="number", format="float", description="Цена за расстояние", example=1500.50),
*         @OA\Property(property="transport_id", type="string", format="uuid", description="UUID транспорта, должен существовать в таблице transports", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="user_id", type="string", format="uuid", description="UUID пользователя, должен существовать в таблице users", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации, должен существовать в таблице organizations", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="add_load_space", type="boolean", description="Дополнительное место для загрузки", nullable=true, example=true),
*         @OA\Property(property="road_back", type="boolean", description="Обратная дорога", nullable=true, example=false),
*         @OA\Property(property="directly_road", type="boolean", description="Прямая дорога", nullable=true, example=true),
*         @OA\Property(property="description", type="string", description="Описание", nullable=true, maxLength=1000, example="Описание маршрута")
*     }
* ),
*
*
* @OA\Schema(
*     schema="OfferContractorCustomerResource",
*     type="object",
*     description="Отклили на предложения перевозчиков, от заказчиков",
*     title="Offer Contractor Resource",
*     properties={
*         @OA\Property(property="id", type="string", format="uuid", example="123e4525-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="invoice_order_customer_id", ref="#/components/schemas/InvoiceOrderCustomerResource", description="Ресурс абстрактного заказа при отклике"),
*         @OA\Property(property="offer_contractor_id", ref="#/components/schemas/OfferContractorResource", description="Ресурс предложения от перевозчика"),
*         @OA\Property(property="organization_id", ref="#/components/schemas/OrganizationResource", description="Ресурс организации"),
*
*     }
* ),
*
* @OA\Schema(
*     schema="TransportResource",
*     type="object",
*     title="Transport Resource",
*     properties={
*         @OA\Property(property="id", type="string", format="uuid", description="UUID транспорта", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="type", type="string", description="Тип транспортного средства: грузовик, фуру, легковое, контейнерный", example="грузовик"),
*         @OA\Property(property="brand_model", type="string", description="Марка и модель - например: Volvo FH, MAN TGS", example="Volvo FH"),
*         @OA\Property(property="year", type="string", description="Год выпуска транспорта", example="2020"),
*         @OA\Property(property="transport_number", type="string", description="Номерной знак", example="A123BC77"),
*         @OA\Property(property="body_volume", type="string", description="Максимальная Вместимость", example="50 куб.м"),
*         @OA\Property(property="body_weight", type="string", description="Максимальная Масса груза", example="20 тонн"),
*         @OA\Property(property="type_body", ref="#/components/schemas/RUTransportBodyTypeEnum"),
*         @OA\Property(property="type_loading", ref="#/components/schemas/RUTransportLoadingTypeEnum"),
*         @OA\Property(property="type_status", ref="#/components/schemas/RUTransportStatusEnum"),
*         @OA\Property(property="type_weight", ref="#/components/schemas/RUTransportTypeWeightEnum"),
*         @OA\Property(property="description", type="string", description="Описание/Заметка", nullable=true, example="Транспорт в хорошем состоянии"),
*         @OA\Property(property="organization_id", type="string", format="uuid", description="UUID организации", nullable=true, example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="driver_id", type="string", format="uuid", description="UUID водителя", example="123e4567-e89b-12d3-a456-426614174000")
*     }
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
*     enum={"legal", "individual"}
*   ),
*   @OA\Property(property="description", type="string", nullable=true, description="Описание организации"),
*   @OA\Property(property="okved", type="string", nullable=true, description="Индустрия организации"),
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

* ),
*
* @OA\Schema(
*    schema="OrderPriceResource",
*    description="Json ресурс методов погрузки грузовика с ценами",
*    title="Loading Truck Methods",
*    @OA\Property(
*        property="FTL",
*        type="object",
*        @OA\Property(property="load_type", type="string", description="Значение метода FTL"),
*        @OA\Property(property="price_km", type="string", description="Цена за 1 км"),
*        @OA\Property(property="price", type="integer", description="Цена метода FTL")
*    ),
*    @OA\Property(
*        property="LTL",
*        type="object",
*        @OA\Property(property="load_type", type="string", description="Значение метода LTL"),
*        @OA\Property(property="price_km", type="string", description="Цена за 1 км"),
*        @OA\Property(property="price", type="integer", description="Цена метода LTL")
*    ),
*    @OA\Property(
*        property="business_lines",
*        type="object",
*        @OA\Property(property="load_type", type="string", description="Значение метода business_lines"),
*        @OA\Property(property="price_km", type="string", description="Цена за 1 км"),
*        @OA\Property(property="price", type="integer", description="Цена метода business_lines")
*    ),
*    @OA\Property(
*        property="more_load",
*        type="object",
*        @OA\Property(property="load_type", type="string", description="Значение метода more_load"),
*        @OA\Property(property="price_km", type="string", description="Цена за 1 км"),
*        @OA\Property(property="price", type="integer", description="Цена метода more_load")
*    ),
* ),
*
*
* @OA\Schema(
*     schema="InvoiceOrderResource",
*     description="JSON ресурс с информацией о ресурсе",
*     title="Your Resource",
*     @OA\Property(property="id", type="string", format="uuid", description="Уникальный идентификатор ресурса", example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"),
*     @OA\Property(property="transport_id", type="string", format="uuid", description="Значение транспорта организации"),
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
*     @OA\Property(property="id_organization_order_units_invoce", type="string", description="Id контракта, его нужно отправлять когда заказчик будет выбирать подрядичка", format="uuid", example="3fa85f64-5717-4562-b3fc-2c963f66afa6" ),
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
* @OA\Schema(
*     schema="AgreementOrderResource",
*     description="JSON ресурс AgreementOrder *Таблица - когда заказчик выбрал исполнителя*",
*     title="Agreement Order Accept Resource",
*     @OA\Property(
*         property="id",
*         type="string",
*         format="uuid",
*         description="Уникальный идентификатор ресурса",
*         example="41e9b50e-22c3-48b4-81be-efd6da3fa95b"
*     ),
*     @OA\Property(property="order_unit_id", ref="#/components/schemas/OrderUnitResource", description="Ресурс Заказа"),
*     @OA\Property(property="organization_contractor_id", ref="#/components/schemas/OrganizationResource", description="Организация откликнувшиеся на заказ"),
*     @OA\Property(property="organization_order_units_invoce_id", ref="#/components/schemas/OrgOrderInvoiceResource", description="organization_order_units_invoce"),
*     @OA\Property(property="agreement_order_accept_id", ref="#/components/schemas/AgreementOrderAcceptResource", description="Ссылка на Agreement Order Accept Resource"),
*
* ),
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
*     @OA\Property(property="postal_code", type="string", description="Почтовый индекс адреса", nullable=true),
*     @OA\Property(property="type_Address", type="string", description="Тип адреса", nullable=true),
*     @OA\Property(property="latitude", type="float", description="Широта адреса"),
*     @OA\Property(property="longitude", type="float", description="Долгота адреса")
* ),
*
* @OA\Schema(
*     schema="AgreementOrderContractorResource",
*     type="object",
*     title="Agreement Order Contractor Resource",
*     properties={
*         @OA\Property(property="id_agreement_order_contractor", type="string", format="uuid", description="UUID соглашения заказа подрядчика", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="offer_contractor_invoice_order_customer_id", type="string", format="uuid", description="UUID отклика (организации - заказчика)", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="agreement_order_contractor_accept_id", type="string", format="uuid", description="UUID Двух стороннего соглашения", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="order_unit_id", type="string", format="uuid", description="UUID заказа", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="organization_contractor_id", type="string", format="uuid", description="UUID организации перевозчика", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="user_id", type="string", format="uuid", description="UUID пользователя заказчика", example="123e4567-e89b-12d3-a456-426614174000")
*     }
* ),
*
* @OA\Schema(
*     schema="AgreementOrderContractorAcceptResource",
*     type="object",
*     title="Agreement Order Contractor Accept Resource",
*     properties={
*         @OA\Property(property="id_agreement_order_contractor_accept", type="string", format="uuid", description="UUID принятия соглашения заказа подрядчика", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="agreement_order_contractor_id", type="string", format="uuid", description="UUID соглашения заказа подрядчика", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="order_bool", type="boolean", description="Статус утверждения со стороны Заказчика", example=true),
*         @OA\Property(property="contractor_bool", type="boolean", description="Статус утверждения со стороны Перевозчика", example=true)
*     }
* ),
*
*
* @OA\Schema(
*     schema="AgreementTenderAcceptResource",
*     type="object",
*     title="Agreement Order Contractor Accept Resource",
*     properties={
*         @OA\Property(property="id_agreement_order_contractor_accept", type="string", format="uuid", description="UUID принятия соглашения заказа подрядчика", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="agreement_order_contractor_id", type="string", format="uuid", description="UUID соглашения заказа подрядчика", example="123e4567-e89b-12d3-a456-426614174000"),
*         @OA\Property(property="order_bool", type="boolean", description="Статус утверждения со стороны Заказчика", example=true),
*         @OA\Property(property="contractor_bool", type="boolean", description="Статус утверждения со стороны Перевозчика", example=true)
*     }
* ),
*
*
* @OA\Schema(
*     schema="AgreementTenderResource",
*     type="object",
*     @OA\Property(property="id_areement_tender", type="string", format="uuid", description="ID соглашения тендера"),
*     @OA\Property(property="lot_tender_response_id", type="string", format="uuid", description="uuid lot_tender_respons"),
*     @OA\Property(property="organization_tender_create_id", type="string", format="uuid", description="ID организации создателя тендера"),
*     @OA\Property(property="lot_tender_id", type="string", format="uuid", description="ID лота тендера"),
*     @OA\Property(property="agreement_tender_accept_id", ref="#/components/schemas/AgreementTenderAcceptResource", description="Соглашение тендера")
* ),
*
* @OA\Schema(
*     schema="LotTenderResponseResource",
*     type="object",
*     @OA\Property(property="id_lot_tender_response", type="string", format="uuid", description="ID ответа на лот тендера"),
*     @OA\Property(property="lot_tender_id", type="string", format="uuid", description="ID лота тендера"),
*     @OA\Property(property="organization_contractor_id", type="string", format="uuid", description="ID организации подрядчика"),
*     @OA\Property(property="invoice_lot_tender_id", type="string", format="uuid", description="ID Описание при отклике перевозчика")
* ),
*
* @OA\Schema(
*     schema="SpecificaDatePeriodResource",
*     type="object",
*     @OA\Property(property="id_specifica_date_period", type="integer", description="ID специфической даты периода"),
*     @OA\Property(property="date", type="string", format="date", description="Конкрентая дата для Тендера (Выполнения заказа)"),
*     @OA\Property(property="count_transport", type="integer", description="Количество транспорта")
* ),
*
* @OA\Schema(
*     schema="LotTenderResource",
*     type="object",
*     @OA\Property(property="id_lot_tender", type="string", format="uuid", description="ID лота тендера"),
*     @OA\Property(property="general_count_transport", type="string", format="uuid", description="Общее количество транспорта"),
*     @OA\Property(property="price_for_km", type="number", format="float", description="Цена за км"),
*     @OA\Property(property="body_volume_for_order", type="number", format="float", description="Объем кузова для заказа"),
*     @OA\Property(property="type_transport_weight", type="string", description="Тип веса транспорта"),
*     @OA\Property(property="type_load_truck", type="string", description="Тип загрузки грузовика"),
*     @OA\Property(property="status_tender", type="string", description="Статус Тендера: черновик, в работе и т.д"),
*     @OA\Property(property="type_tender", type="string", description="Тип Тендера: Периодический/Разовый "),
*     @OA\Property(property="date_start", type="string", format="date", description="Дата начала"),
*     @OA\Property(property="period", type="string", format="uuid", description="Период"),
*     @OA\Property(property="day_period", type="string", format="uuid", description="Дневной период"),
*     @OA\Property(property="organization_id", type="string", format="uuid", description="ID организации"),
*     @OA\Property(property="agreement_document_tender_link", type="string", format="url", description="Ссылка на документ соглашения тендера - договор - будет обязательный и только один"),
*     @OA\Property(property="array_application_document_tender_link", type="array", @OA\Items(type="string", format="url"), description="Ссылки на документы приложения для тендера"),
*     @OA\Property(property="array_specifica_date_period", type="array", @OA\Items(ref="#/components/schemas/SpecificaDatePeriodResource"), description="Массив специфических дат периода, здесь указываются конкретные даты тендера + количество транспорта")
* ),
*
*
*
*
* ///////////Enums
*
*
*
* @OA\Schema(
*     schema="TransportBodyTypeEnum",
*     type="string",
*     description="Тип кузова транспорта",
*     enum={
*         "flatbed",
*         "curtainside",
*         "box",
*         "refrigerated",
*         "tanker",
*         "dump",
*         "car_carrier",
*         "logging",
*         "crane",
*         "concrete_mixer",
*         "tow",
*         "insulated",
*         "container",
*         "garbage",
*         "livestock",
*         "lowboy",
*         "scrap_metal",
*         "covered_flatbed",
*         "bulk_powder_tanker",
*         "side_curtain"
*     },
*     example="flatbed"
* ),
*
* @OA\Schema(
*     schema="TransportLoadingTypeEnum",
*     type="string",
*     description="Тип загрузки транспорта",
*     enum={
*         "top",
*         "side",
*         "rear",
*         "liquid_bulk",
*         "dry_bulk"
*     },
*     example="top"
* ),
*
* @OA\Schema(
*     schema="TransportStatusEnum",
*     type="string",
*     description="Статус транспорта",
*     enum={
*         "free",
*         "work",
*         "repair"
*     },
*     example="free"
* ),
*
*
* @OA\Schema(
*     schema="TransportTypeWeightEnum",
*     type="string",
*     description="Весовая категория транспорта",
*     enum={
*         "extraSmall",
*         "small",
*         "medium",
*         "large",
*         "extraLarge",
*         "superSize"
*     },
*     example="medium"
* ),
*
* @OA\Schema(
*     schema="RUTransportBodyTypeEnum",
*     type="string",
*     description="Тип кузова транспорта",
*     enum={
*         "бортовой",
*         "тентованный",
*         "фургон",
*         "рефрижератор",
*         "цистерна",
*         "самосвал",
*         "автовоз",
*         "лесовоз",
*         "кран манипулятор",
*         "бетономешалка",
*         "эвакуатор",
*         "изотермический",
*         "контейнеровоз",
*         "мусоровоз",
*         "животновоз",
*         "низкорамник",
*         "ломовоз",
*         "крытый бортовой",
*         "автоцистерна для сыпучих материалов",
*         "шторный полуприцеп"
*     },
*     example="бортовой"
* ),
*
* @OA\Schema(
*     schema="RUTransportLoadingTypeEnum",
*     type="string",
*     description="Тип загрузки транспорта",
*     enum={
*         "верхняя загрузка",
*         "боковая загрузка",
*         "задняя загрузка",
*         "наливная загрузка",
*         "насыпная загрузка"
*     },
*     example="верхняя загрузка"
* ),
*
* @OA\Schema(
*     schema="RUTransportStatusEnum",
*     type="string",
*     description="Статус транспорта",
*     enum={
*         "Свободен",
*         "В Эксплуатации",
*         "На ремонте"
*     },
*     example="Свободен"
* ),
*
*
*
* @OA\Schema(
*     schema="RUTransportTypeWeightEnum",
*     type="string",
*     description="Весовая категория транспорта",
*     enum={
*         "до 0.8 тонны",
*         "до 1.5 тонны",
*         "до 3 тонны",
*         "до 5 тонны",
*         "до 10 тонны",
*         "Более 10 тонны"
*     },
*     example="до 3 тонны"
* ),
*
* @OA\Schema(
*     schema="IndividualPeopleResource",
*     type="object",
*     title="IndividualPeopleResource",
*     description="Individual People Resource",
*     @OA\Property(
*         property="id_individual_people",
*         type="string",
*         format="uuid",
*         description="UUID of the individual person",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="first_name",
*         type="string",
*         description="First name of the individual person",
*         example="John"
*     ),
*     @OA\Property(
*         property="last_name",
*         type="string",
*         description="Last name of the individual person",
*         example="Doe"
*     ),
*     @OA\Property(
*         property="father_name",
*         type="string",
*         description="Father's name of the individual person",
*         example="Smith"
*     ),
*     @OA\Property(
*         property="position",
*         type="string",
*         description="Позиция (пока что обычный string)",
*         example="Manager"
*     ),
*     @OA\Property(
*         property="other_contact",
*         type="string",
*         description="Other contact information of the individual person",
*         example="Some contact info"
*     ),
*     @OA\Property(
*         property="personal_area_id",
*         type="string",
*         format="uuid",
*         description="UUID of the personal area - id кабинета",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="email",
*         type="string",
*         format="email",
*         description="Email",
*         example="john.doe@example.com"
*     ),
*     @OA\Property(
*         property="phone",
*         type="string",
*         description="Phone number of the individual person",
*         example="71234567890"
*     ),
*     @OA\Property(
*         property="comment",
*         type="string",
*         description="Comment about the individual person",
*         example="Some comment"
*     )
* ),
*
* @OA\Schema(
*     schema="DriverPeopleResource",
*     type="object",
*     title="DriverPeopleResource",
*     description="Driver People Resource",
*     @OA\Property(
*         property="id_driver_people",
*         type="string",
*         format="uuid",
*         description="UUID of the driver person",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="personal_area_id",
*         type="string",
*         format="uuid",
*         description="UUID of the personal area",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="individual_people_id",
*         type="string",
*         format="uuid",
*         description="UUID of the individual person",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="organization_id",
*         type="string",
*         format="uuid",
*         description="UUID of the organization",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="series",
*         type="integer",
*         format="int32",
*         description="Серия Водительского Удостоверения",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="number",
*         type="integer",
*         format="int32",
*         description="UUID of the organization",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="date_get",
*         type="string",
*         format="date",
*         description="UUID of the organization",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
* ),
*
* @OA\Schema(
*     schema="StorekeeperPeopleResource",
*     type="object",
*     title="StorekeeperPeopleResource",
*     description="Storekeeper People Resource",
*     @OA\Property(
*         property="id_storekeeper_people",
*         type="string",
*         format="uuid",
*         description="UUID of the driver person",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="personal_area_id",
*         type="string",
*         format="uuid",
*         description="UUID of the personal area",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="individual_people_id",
*         type="string",
*         format="uuid",
*         description="UUID of the individual person",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
*     @OA\Property(
*         property="organization_id",
*         type="string",
*         format="uuid",
*         description="UUID of the organization",
*         example="123e4567-e89b-12d3-a456-426614174000"
*     ),
* ),
*
*/
abstract class Controller
{
    //
}
