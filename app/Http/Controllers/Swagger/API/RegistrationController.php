<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\Post(
 *
 *      path="/api/registration",
 *      summary="вернуть токен для user по email/phone и password",
 *      tags={"Login\Registration"},
 *
 *       @OA\RequestBody(
 *           @OA\JsonContent(
 *               allOf={
 *                  @OA\Schema(
 *                      @OA\Property(property="email", type="string", format="email", description="User's email address", example="test@gmail.com"),
 *                      @OA\Property(property="phone", type="string", description="User's phone number", pattern="^\+?[0-9]{1,3}[0-9]{9}$", example="79200264425"),
 *
 *                      @OA\Property(property="first_name", type="string", description="User's first name", example="Ваня"),
 *                      @OA\Property(property="last_name", type="string", description="User's last name", example="Овсянников"),
 *                      @OA\Property(property="father_name", type="string", description="User's father name", example="Шрекович=)"),
 *                      @OA\Property(property="role", type="string", description="User's role, can only be 'admin'", enum={"admin"}, example="admin"),
 *
 *
 *                      @OA\Property(property="password", type="string", format="password", description="User's password", example="Pas123!"),
 *                      @OA\Property(property="password_confirmation", type="string", format="password", description="Password confirmation", example="Pas123!"),
 *
 *                      @OA\Property(property="agreement", type="boolean", format="password", description="User's agreement", example=true),
 *                  )
 *               },
 *           ),
 *       ),
 *
 *       @OA\Response(
 *           response=201,
 *           description="Регистрация успешна.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", ref="#/components/schemas/BearerToken"),
 *               @OA\Property(property="message", type="string", example="Successfully registration."),
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
 *       @OA\Response(
 *           response=401,
 *           description="Ошибка получения токена.",
 *           @OA\JsonContent(
 *               @OA\Property(property="message_error", type="string", example="Error receiving token."),
 *           ),
 *       ),
 *
 * )
*/
class RegistrationController extends Controller
{

}
