<?php

namespace App\Http\Controllers\Swagger\API;


/**
 * @OA\post(
 *
 *      path="/api/organizations",
 *      summary="Создать Organization по авторизированному пользователю",
 *      tags={"Organization"},
 *
 *       @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *             required={"name", "address", "phone", "email", "website", "type", "inn", "type_cabinet"},
 *             @OA\Property(property="name", type="string", description="Name of the organization", maxLength=101, minLength=2, example="My Company"),
 *             @OA\Property(property="address", type="string", description="Address of the organization", maxLength=255, minLength=12, example="123 Example Street, City, Country"),
 *             @OA\Property(property="phone", type="string", description="Contact phone number", example="+1234567890"),
 *             @OA\Property(property="email", type="string", format="email", description="Contact email", maxLength=100, example="contact@example.com"),
 *             @OA\Property(property="website", type="string", description="Website URL", example="https://www.example.com"),
 *             @OA\Property(property="type", type="string", enum={"legal", "individual"}, description="Type of organization, either 'legal' or 'individual'", example="legal"),
 *             @OA\Property(property="description", type="string", nullable=true, description="Description of the organization", example="A leading company in the okved."),
 *             @OA\Property(property="okved", type="string", nullable=true, description="okved type", example="Technology"),
 *             @OA\Property(property="founded_date", type="string", format="date", nullable=true, description="Date the organization was founded", example="2020-01-01"),
 *             @OA\Property(property="inn", type="string", description="INN number; either 10 or 12 digits", pattern="^(([0-9]{12})|([0-9]{10}))?$", example="1234567890"),
 *             @OA\Property(property="type_cabinet", type="string", description="**Тип кабинета: Заказчик, Склад, Перевозчик**", enum={"customer", "store_space", "carrier"} ),
 *             @OA\Property(
 *                 property="kpp",
 *                 type="string",
 *                 nullable=true,
 *                 description="KPP number (обязательный параметр когда 'legal')",
 *                 pattern="^[0-9]{9}$",
 *                 example="123456789"
 *             ),
 *             @OA\Property(
 *                 property="registration_number",
 *                 type="string",
 *                 nullable=true,
 *                 description="огрн/огрнип number (Либо при ИП либо при ООО)",
 *                 pattern="^[0-9]{15}$",
 *                 example="1234567890123"
 *             ),
 *          )
 *       ),
 *
 *      @OA\Response(
 *            response=201,
 *            description="Организация успешна создана.",
 *            @OA\JsonContent(
 *                @OA\Property(property="data", ref="#/components/schemas/OrganizationResource"),
 *                @OA\Property(property="message", type="string", example="Create organization."),
 *            ),
 *      ),
 *
 *       @OA\Response(
 *            response=400,
 *            description="Ошибка создания организации.",
 *            @OA\JsonContent(
 *                @OA\Property(property="data", example="null"),
 *                @OA\Property(property="message", type="string", example="Faild create organization."),
 *            ),
 *      ),
 *
 *
 *      @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 * ),
 *
 * @OA\GET(
 *
 *      path="/api/organizations/{organization::uuid}",
 *      summary="Вернуть запись organization по id",
 *      tags={"Organization"},
 *      @OA\Parameter(
 *              name="organization::uuid",
 *              in="path",
 *              required=true,
 *              description="UUID Организации",
 *              @OA\Schema(
 *                  type="string",
 *                  format="uuid"
 *              )
 *       ),
 *
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property( property="data", type="object", ref="#/components/schemas/OrganizationResource" ),
 *              @OA\Property(property="message", type="string", example="Return organization select."),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=404,
 *          description="Организация не найдена.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Такой организации не существует."),
 *          ),
 *      ),
 *
 *
 *      @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 * ),
 *
 *  @OA\GET(
 *
 *      path="/api/organizations",
 *      summary="Вернуть все записи organization",
 *      tags={"Organization"},
 *
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/OrganizationResource") ),
 *              @OA\Property(property="message", type="string", example="Return organization select."),
 *          ),
 *      ),
 *
 *
 *      @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 * ),
 *
 *
 *
 */
class OrganizationController
{

}
