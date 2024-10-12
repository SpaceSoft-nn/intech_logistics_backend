<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\get(
 *
 *      path="/api/matrix-distance",
 *      summary="вернуть токен для user по email/phone и password",
 *      tags={"Matrix Distance"},
 *
 *      @OA\Response(
 *            response=200,
 *            description="Успешный возврат матрицы расстояний.",
 *            @OA\JsonContent(
 *                @OA\Property(property="data", ref="#/components/schemas/MatrixDistanceResource"),
 *                @OA\Property(property="message", type="string", example="Return Orders."),
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
 * )
 */
class MatrixDistance extends Controller
{

}
