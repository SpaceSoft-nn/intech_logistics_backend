<?php

namespace App\Http\Controllers\Swagger\API;

/**
* @OA\Get(
*      path="/api/individual-people/storekeepers",
*      summary="Получить список кладовщиков",
*      tags={"StorekeeperPeople"},
*      @OA\Response(
*          response=200,
*          description="Список кладовщиков",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/StorekeeperPeopleResource")),
*              @OA\Property(property="message", type="string", example="Return all storekeeper people."),
*          ),
*      ),
*      @OA\Response(
*          response=500,
*          description="Ошибка сервера",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
*              @OA\Property(property="code", type="integer", example=500),
*          ),
*      ),
* ),
*
* @OA\Get(
*      path="/api/individual-people/storekeepers/{storekeeper}",
*      summary="Получить информацию о конкретном кладовщике",
*      tags={"StorekeeperPeople"},
*      @OA\Parameter(
*          name="storekeeper",
*          in="path",
*          required=true,
*          description="UUID кладовщика",
*          @OA\Schema(
*              type="string",
*              format="uuid"
*          )
*      ),
*      @OA\Response(
*          response=200,
*          description="Информация о кладовщике",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="object", ref="#/components/schemas/StorekeeperPeopleResource"),
*              @OA\Property(property="message", type="string", example="Return storekeeper people for uuid."),
*          ),
*      ),
*      @OA\Response(
*          response=404,
*          description="Кладовщик не найден",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Такого кладовщика не существует."),
*          ),
*      ),
*      @OA\Response(
*          response=500,
*          description="Ошибка сервера",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
*              @OA\Property(property="code", type="integer", example=500),
*          ),
*      ),
* ),
*
* @OA\Post(
*      path="/api/individual-people/storekeepers",
*      summary="Создать нового кладовщика",
*      tags={"StorekeeperPeople"},
*      @OA\RequestBody(
*          required=true,
*          @OA\JsonContent(
*              @OA\Property(property="personal_area_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="individual_people_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
*              @OA\Property(property="organization_id", nullable=true, type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
*          )
*      ),
*      @OA\Response(
*          response=201,
*          description="Кладовщик создан",
*          @OA\JsonContent(
*              @OA\Property(property="data", type="object", ref="#/components/schemas/StorekeeperPeopleResource"),
*              @OA\Property(property="message", type="string", example="Create storekeeper people."),
*          ),
*      ),
*      @OA\Response(
*          response=404,
*          description="Ошибка при создании кладовщика",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Failed create storekeeper people."),
*          ),
*      ),
*      @OA\Response(
*          response=500,
*          description="Ошибка сервера",
*          @OA\JsonContent(
*              @OA\Property(property="message_error", type="string", example="Общая ошибка сервера."),
*              @OA\Property(property="code", type="integer", example=500),
*          ),
*      ),
* ),
*/
class StorekeeperPeopleController
{

}
