<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\POST(
 *
 *      path="/api/login",
 *      summary="вернуть токен для user по email/phone и password",
 *      tags={"Login\Registration"},
 *
 *       @OA\RequestBody(
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                     @OA\Property(property="email", type="string", format="email", description="User's email address", example="test@gmail.com"),
 *                     @OA\Property(property="phone", type="string", description="User's phone number", pattern="^\+?[0-9]{1,3}[0-9]{9}$", example="+79200264425"),
 *                     @OA\Property(property="password", type="string", format="password", description="User's password", example="Pas123!"),
 *                 )
 *              },
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3MTQwMDMwNTcsImV4cCI6MTcxNDAwNjY1NywibmJmIjoxNzE0MDAzMDU3LCJqdGkiOiJaampTNWRmOHZtdHNZbWJ0Iiwic3ViIjoiMSIsInBydiI6IjRhNmUyNTJkNDljYzM1ZjlhNmQyODk3ZmRlNGY5MzE0NmU3YzgwMmMifQ.6J4NAHBKlRIG5ZAtgIwXHuToFnG1mCCXwgxrf6rL9DY"),
*                  @OA\Property(property="token_type", type="number", example="Bearer"),
*                  @OA\Property(property="expires_in", type="integer", example="3600"),
 *          ),
 *      ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Нужно указать только email или phone",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Only Email or Phone"),
 *         ),
 *     ),
 *
 *     @OA\Response(
 *          response=400,
 *          description="Only Email or Phone",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Only Email or Phone"),
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 * )
 */
class LoginController extends Controller
{

}
