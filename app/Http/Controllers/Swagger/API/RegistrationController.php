<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *     path="/api/registration",
 *     summary="Регистрация пользователя и организации",
 *     tags={"Login\Registration"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="email", type="string", format="email", description="Email пользователя", example="test@gmail.com"),
 *             @OA\Property(property="phone", type="string", description="Телефон пользователя", pattern="^\+?[0-9]{1,3}[0-9]{9}$", example="79200264425"),
 *             @OA\Property(property="password", type="string", format="password", description="Пароль пользователя", example="Pas123!"),
 *             @OA\Property(property="password_confirmation", type="string", format="password", description="Подтверждение пароля", example="Pas123!"),
 *             @OA\Property(property="first_name", type="string", description="Имя пользователя", example="Ваня"),
 *             @OA\Property(property="last_name", type="string", description="Фамилия пользователя", example="Овсянников"),
 *             @OA\Property(property="father_name", type="string", description="Отчество пользователя", example="Шрекович"),
 *             @OA\Property(property="role", type="string", description="Роль пользователя, может быть только 'admin'", enum={"admin"}, example="admin"),
 *             @OA\Property(property="agreement", type="boolean", description="Согласие пользователя", example=true),
 *             @OA\Property(property="name", type="string", description="Название организации", example="ООО Ромашка"),
 *             @OA\Property(property="address", type="string", description="Адрес организации", example="г. Москва, ул. Ленина, д. 1"),
 *             @OA\Property(property="phone_org", type="string", description="Телефон организации", example="79200264425"),
 *             @OA\Property(property="email_org", type="string", format="email", description="Email организации", example="org@gmail.com"),
 *             @OA\Property(property="website", type="string", description="Вебсайт организации", example="www.org.com"),
 *             @OA\Property(property="type", type="string", description="Тип организации", example="ООО"),
 *             @OA\Property(property="description", type="string", description="Описание организации", example="Описание организации"),
 *             @OA\Property(property="okved", type="string", description="ОКВЭД организации", example="62.01"),
 *             @OA\Property(property="founded_date", type="string", format="date", description="Дата основания организации", example="2023-10-01"),
 *             @OA\Property(property="inn", type="string", description="ИНН организации", example="1234567890"),
 *             @OA\Property(property="type_cabinet", type="string", description="Тип кабинета", example="admin"),
 *             @OA\Property(property="kpp", type="string", description="КПП организации", example="123456789"),
 *             @OA\Property(property="registration_number", type="string", description="Регистрационный номер организации", example="1234567890123")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Регистрация успешна.",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="token", type="string", description="Токен"),
 *                 @OA\Property(property="organization", ref="#/components/schemas/OrganizationResource"),
 *                 @OA\Property(property="user", ref="#/components/schemas/UserResource")
 *             ),
 *             @OA\Property(property="message", type="string", example="Successfully registration.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Общая ошибка сервера.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message_error", type="string", example="Error server"),
 *             @OA\Property(property="code", type="integer", example=500)
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Ошибка получения токена.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message_error", type="string", example="Error receiving token.")
 *         )
 *     )
 * )
 */
class RegistrationController extends Controller
{

}
