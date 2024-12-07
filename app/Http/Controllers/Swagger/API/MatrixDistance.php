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
 * @OA\Post(
 *     path="/api/matrix-distance",
 *     summary="Создать матрицу расстояний",
 *     description="Создает новую запись матрицы расстояний",
 *     tags={"Matrix Distance"},
 *
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             required={"city_name_start", "city_name_end", "distance"},
 *             @OA\Property(
 *                 property="city_name_start",
 *                 @OA\Schema(
 *                     type="string",
 *                 ),
 *                 description="Название начального города"
 *             ),
 *             @OA\Property(
 *                 property="city_name_end",
 *                 @OA\Schema(
 *                     type="string",
 *                 ),
 *                 description="Название конечного города"
 *             ),
 *             @OA\Property(
 *                 property="distance",
 *                 @OA\Schema(
 *                     type="string",
 *                     format="float",
 *                 ),
 *                 description="Расстояние между городами"
 *             ),
 *             @OA\Property(
 *                 property="city_start_gar_id",
 *                 @OA\Schema(
 *                     type="string",
 *                     format="uuid",
 *                 ),
 *                 description="UUID начального города",
 *                 nullable=true
 *             ),
 *             @OA\Property(
 *                 property="city_end_gar_id",
 *                 @OA\Schema(
 *                     type="string",
 *                     format="uuid",
 *                 ),
 *                 description="UUID конечного города",
 *                 nullable=true
 *             )
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Создано",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="data",
 *                 ref="#/components/schemas/MatrixDistanceResource"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Matrix Distance создана успешно."
 *             )
 *         )
 *     ),
 *
 *
 *     @OA\Response(
 *         response=500,
 *         description="Внутренняя ошибка сервера",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="error",
 *                 type="string",
 *                 example="Произошла ошибка на сервере."
 *             )
 *         )
 *     )
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
