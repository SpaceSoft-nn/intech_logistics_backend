<?php

namespace App\Http\Controllers\Swagger\API;

/**
 * @OA\Get(
 *      path="/api/individual-peoples",
 *      summary="Получить список физических лиц",
 *      tags={"IndividualPeople"},
 *      @OA\Response(
 *          response=200,
 *          description="Список Физических лиц",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/IndividualPeopleResource")),
 *              @OA\Property(property="message", type="string", example="Return all individual people."),
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
 * )
 *
 *
 * @OA\Get(
 *      path="/api/individual-peoples/{individualPeople}",
 *      summary="Получить информацию о конкретном физическом лице",
 *      tags={"IndividualPeople"},
 *      @OA\Parameter(
 *          name="individualPeople",
 *          in="path",
 *          required=true,
 *          description="UUID физического лица",
 *          @OA\Schema(
 *              type="string",
 *              format="uuid"
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Информация о физическом лице",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/IndividualPeopleResource"),
 *              @OA\Property(property="message", type="string", example="Return individual people for uuid."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="физическое лицо не найдено",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Такого индивидуального человека не существует."),
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
 * )
 *
 *
 *
 * @OA\Post(
 *      path="/api/individual-peoples",
 *      summary="Создать новое физическо лицо",
 *      tags={"IndividualPeople"},
 *      @OA\RequestBody(
 *
 *          @OA\JsonContent(
 *              @OA\Property(property="first_name", type="string", example="John"),
 *              @OA\Property(property="last_name", type="string", example="Doe"),
 *              @OA\Property(property="father_name", type="string", example="Smith"),
 *              @OA\Property(property="position", type="string", example="Manager"),
 *              @OA\Property(property="other_contact", type="string", example="Some contact info"),
 *              @OA\Property(property="personal_area_id", type="string", format="uuid", example="123e4567-e89b-12d3-a456-426614174000"),
 *              @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *              @OA\Property(property="phone", nullable=true, type="string", example="71234567890"),
 *              @OA\Property(property="comment", nullable=true, type="string", example="Some comment")
 *          )
 *      ),
 *      @OA\Response(
 *          response=201,
 *          description="Физическое лицо создано",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object", ref="#/components/schemas/IndividualPeopleResource"),
 *              @OA\Property(property="message", type="string", example="Create individual people."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Ошибка при создании физического лица",
 *          @OA\JsonContent(
 *              @OA\Property(property="message_error", type="string", example="Failed create individual people."),
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
 * )
 */
class IndividualPeopleController
{

}
