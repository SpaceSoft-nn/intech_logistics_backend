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
 * ),
 *
 * @OA\Get(
 *     path="/api/matrix-distance/filter",
 *     summary="Вернуть матрицу расстояний по Городу start/end (в будущем по gar_id) ",
 *     description="Возвращает матричные расстояния",
 *     tags={"Matrix Distance"},
 *     @OA\Parameter(
 *         name="city_name_start",
 *         in="query",
 *         description="Название начального города",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *
 *     @OA\Parameter(
 *         name="city_name_end",
 *         in="query",
 *         description="Название конечного города",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *         )
 *     ),
 *     @OA\Parameter(
 *         name="city_start_gar_id",
 *         in="query",
 *         description="UUID начального города",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             format="uuid",
 *         )
 *     ),
 *
 *     @OA\Parameter(
 *         name="city_end_gar_id",
 *         in="query",
 *         description="UUID конечного города",
 *         required=false,
 *         @OA\Schema(
 *             type="string",
 *             format="uuid",
 *         )
 *
 *     ),
 *
 *     @OA\Response(
 *          response=200,
 *          description="Ok",
 *          @OA\JsonContent(
 *              @OA\Property( property="data", type="object", ref="#/components/schemas/MatrixDistanceResource" ),
 *              @OA\Property(property="message", type="string", example="Get Matrix Distance."),
 *          ),
 *     ),
 *
 *
 *     @OA\Response(
 *         response=400,
 *         description="Неверные параметры запроса",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="error",
 *                 type="string"
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=500,
 *         description="Внутренняя ошибка сервера",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="error",
 *                 type="string"
 *             )
 *         )
 *     )
 * ),
 *
 */
class MatrixDistance extends Controller
{

}
