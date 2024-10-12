<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
 * @OA\get(
 *
 *      path="/api/region-economic-status",
 *      summary="вернуть токен для user по email/phone и password",
 *      tags={"Region Economic"},
 *
 *
 *      @OA\Response(
 *           response=200,
 *           description="Успешный возврат всех данных об экономическом статусе регионов.",
 *           @OA\JsonContent(
 *               @OA\Property(property="data", ref="#/components/schemas/RegionEconomicFactorResource"),
 *               @OA\Property(property="message", type="string", example="Return Orders."),
 *           ),
 *       ),
 *
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
class RegionEconomicFactor extends Controller
{

}
