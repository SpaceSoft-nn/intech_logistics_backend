<?php
namespace App\Modules\Auth\Presentation\Http\Controllers\Swagger\Jwt;

use App\Modules\Auth\Presentation\Http\Controllers\Controller;

/**
 * 
 * @OA\Post(
 *
 *      path="/api/auth/me",
 *      summary="вернуть user - по токену",
 *      tags={"Auth JWT"},
 *
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="string", description="Отправить bearer токен из header - пустой запрос", example="bearer token")
 *          ),
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Successfully return user",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", ref="#/components/schemas/UserResource"),
 *              @OA\Property(property="message", type="string", example="Successfully return user"),
 *          )
 *      ),
 *
 *     @OA\Response(
 *          response=401,
 *          description="Не авторизован.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *              @OA\Property(property="code", type="integer", example="401"),
 *          ),
 *      ),
 *
 *     @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 *
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *
 * ),
 *
 * @OA\Post(
 *
 *     path="/api/auth/logout",
 *     summary="Удалить актуальный токен",
 *     tags={"Auth JWT"},
 *
 *
 *     @OA\RequestBody(
 *        @OA\JsonContent(
 *             @OA\Property(property="data", type="string", description="Отправить bearer токен из header - пустой запрос", example="bearer token")
 *        ),
 *     ),
 *
 *
 *     @OA\Response(
 *         response="200",
 *         description="Successfully logged out",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="string", example="null"),
 *             @OA\Property(property="message", type="integer", example="Successfully logged out"),
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Не авторизован.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *             @OA\Property(property="code", type="integer", example="401"),
 *         ),
 *     ),
 *
 *
 *     @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 *
 *     security={
 *         {"bearerAuth": {}}
 *     },
 * ),
 *
 * @OA\Post(
 *
 *     path="/api/auth/refresh",
 *     summary="Удалить акутальный токен и вернуть новый",
 *     tags={"Auth JWT"},
 *
 *
 *     @OA\RequestBody(
 *        @OA\JsonContent(
 *             @OA\Property(property="data", type="string", description="Отправить bearer токен из header - пустой запрос", example="bearer token")
 *        ),
 *     ),
 *
 *
 *     @OA\Response(
 *         response="200",
 *         description="Successfully refresh new token",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                  @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3MTQwMDMwNTcsImV4cCI6MTcxNDAwNjY1NywibmJmIjoxNzE0MDAzMDU3LCJqdGkiOiJaampTNWRmOHZtdHNZbWJ0Iiwic3ViIjoiMSIsInBydiI6IjRhNmUyNTJkNDljYzM1ZjlhNmQyODk3ZmRlNGY5MzE0NmU3YzgwMmMifQ.6J4NAHBKlRIG5ZAtgIwXHuToFnG1mCCXwgxrf6rL9DY"),
 *                  @OA\Property(property="token_type", type="number", example="Bearer"),
 *                  @OA\Property(property="expires_in", type="integer", example="3600"),
 *              ),
 *              @OA\Property(property="message", type="string", example="Successfully refresh new token"),
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=401,
 *         description="Не авторизован.",
 *         @OA\JsonContent(
 *             @OA\Property(property="message_error", type="string", example="Не авторизован."),
 *             @OA\Property(property="code", type="integer", example="401"),
 *         ),
 *     ),
 *
 *
 *     @OA\Response(
 *          response=500,
 *          description="Общая ошибка сервера.",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
 *              @OA\Property(property="code", type="integer", example="500"),
 *          ),
 *      ),
 *
 *     security={
 *         {"bearerAuth": {}}
 *     },
 *
 * ),
 *
 *
 * @OA\Schema(
 *    schema="BearerToken",
 *    title="Bearer Token Object",
 *    @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE3MTQwMDMwNTcsImV4cCI6MTcxNDAwNjY1NywibmJmIjoxNzE0MDAzMDU3LCJqdGkiOiJaampTNWRmOHZtdHNZbWJ0Iiwic3ViIjoiMSIsInBydiI6IjRhNmUyNTJkNDljYzM1ZjlhNmQyODk3ZmRlNGY5MzE0NmU3YzgwMmMifQ.6J4NAHBKlRIG5ZAtgIwXHuToFnG1mCCXwgxrf6rL9DY"),
 *    @OA\Property(property="token_type", type="number", example="Bearer"),
 *    @OA\Property(property="expires_in", type="integer", example="3600"),
 * ),
 *
 *
 * @OA\Schema(
 *    schema="UserResource",
 *    title="User Resource",
 *    @OA\Property(property="id", type="string", format="uuid"),
 *    @OA\Property(property="first_name", type="string"),
 *    @OA\Property(property="last_name", type="string"),
 *    @OA\Property(property="father_name", type="string"),
 *    @OA\Property(property="role", type="string", enum={"admin", "manager", "observer"} ),
 *    @OA\Property(property="auth", type="boolean"),
 *    @OA\Property(property="personal_area_id", type="string", format="uuid"),
 *    @OA\Property(property="email_id", type="string", format="uuid"),
 *    @OA\Property(property="phone_id", type="string", format="uuid"),
 * ),
 *
 *
 */
class AuthController extends Controller
{

}
