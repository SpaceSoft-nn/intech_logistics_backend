<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;

/**
* @OA\Get(
*
*      path="/api/users",
*      summary="Получить всех user - которые принадлежат организации",
*      tags={"Users"},
*      @OA\Parameter(
*         name="organization_id",
*         in="header",
*         required=true,
*         @OA\Schema(
*             type="string"
*         ),
*         description="Идентификатор организации, который должен быть передан в заголовке"
*      ),
*
*       @OA\Response(
*           response=200,
*           description="Успешный возврат Заказов.",
*           @OA\JsonContent(
*               @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/UserResource") ),
*               @OA\Property(property="message", type="string", example="Return all user by organization."),
*           ),
*       ),
*
*
* ),
*
* @OA\Patch(
*
*      path="/api/users/{user::uuid}/active",
*      summary="Активировать пользовател в организации, по заявке от администратора этой организации.",
*      tags={"Users"},
*      @OA\Parameter(
*         name="organization_id",
*         in="header",
*         required=true,
*         @OA\Schema(
*             type="string"
*         ),
*         description="Идентификатор организации, который должен быть передан в заголовке"
*      ),
*      @OA\Parameter(
*          name="user::uuid",
*          in="path",
*          required=true,
*          description="UUID пользователя",
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*      ),
*
*      @OA\Response(
*           response=200,
*           description="Успешный возврат Заказов.",
*           @OA\JsonContent(
*               @OA\Property(property="data", type="object", ref="#/components/schemas/UserResource" ),
*               @OA\Property(property="message", type="string", example="Данный user - был активирован в организации."),
*           ),
*      ),
*
*      @OA\Response(
*           response=404,
*           description="Данный user - уже был активирован.",
*           @OA\JsonContent(
*               @OA\Property(property="message", type="string", example="Данный user - уже был активирован."),
*           ),
*      ),
*
*      @OA\Response(
*           response=403,
*           description="Данный пользователь: uuid не принадлежит к организации",
*           @OA\JsonContent(
*               @OA\Property(property="message", type="string", example="Данный пользователь: uuid не принадлежит к организации"),
*           ),
*      ),
* ),
*
*
*/
class UserController extends Controller
{

}
