<?php

namespace App\Http\Controllers\Swagger\API;

use App\Http\Controllers\Controller;


/**
 * @OA\Post(
 *
 *      path="/api/notification/confirm",
 *      summary="Активировать email или phone по коду",
 *      tags={"Notification"},
 *
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                      @OA\Property(property="code", type="integer", format="int32", description="Шестизначный код", minimum=100000, maximum=999999, example="000000"),
 *                      @OA\Property(property="type", type="string", description="Тип отправки phone/email", enum={"phone", "email"}, example="email"),
 *                      @OA\Property(property="uuid_send", type="string", format="uuid", description="uuid_send получен при отправке нотификации"),
 *                  )
 *              },
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Successfully confirm notification",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="message", type="string", example="Код успешно подтверждён."),
 *                  @OA\Property(property="status", type="boolean", example="true")
 *              ),
 *              @OA\Property(property="message", type="string", example="Confirm code.")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="500",
 *          description="Ошибка на сервере",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Ошибка на сервере"),
 *          )
 *      ),
 *
 *
 *      @OA\Response(
 *          response="400",
 *          description="OpenAPI не поддерживает повторяющиеся коды ответов => Количество попыток ввода - исчерпано | Код подтверждения неверный.",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="message", type="string", example="Количество попыток ввода - исчерпано."),
 *                  @OA\Property(property="status", type="boolean", example="false")
 *              ),
 *              @OA\Property(property="message", type="string", example="Faild confirm code.")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="404",
 *          description="ошибка проверки кода Email/Phone",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Error confirm"),
 *          )
 *      ),
 *
 *),
 *
 * @OA\Post(
 *
 *      path="/api/notification/send",
 *      summary="Отправить код по email или phone",
 *      tags={"Notification"},
 *
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              allOf={
 *                 @OA\Schema(
 *                      @OA\Property(property="email", type="string", description="Email - значение", example="test@gmail.com"),
 *                      @OA\Property(property="phone", type="string", description="Phone - значение", example="79201837461"),
 *                      @OA\Property(property="type", type="string", enum={"phone", "email"}, description="Тип отправки нотификации email/phone - указывать в поле type:email/phone", example="email"),
 *                  )
 *              },
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="500",
 *          description="Ошибка на сервере",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="Ошибка на сервере"),
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="400",
 *          description="OpenAPI не поддерживает повторяющиеся коды ответов => Ограничение на отправку в несколько минут| Исчерпано максимальное количество ввода | Неверный код",
 *          @OA\JsonContent(
 *              @OA\Property(property="data", type="object",
 *                  @OA\Property(property="message", type="string", example="Повторная отправка возможна через несколько минут."),
 *                  @OA\Property(property="status", type="boolean", example="false")
 *              ),
 *              @OA\Property(property="message", type="string", example="Faild send notification.")
 *          )
 *      ),
 *
 *      @OA\Response(
 *          response="200",
 *          description="Успешная отправка нотификации",
 *          @OA\JsonContent(
 *              @OA\Property(property="uuid_send", type="string", format="uuid", description="uuid_send получен при отправке нотификации"),
 *              @OA\Property(property="message", type="string", example="Отправка была успешна."),
 *              @OA\Property(property="status", type="boolean", example="true"),
 *          ),
 *          @OA\Property(property="message", type="string", example="Send notification.")
 *      ),
 *
 * ),
 *
 *
 *
 */
class NotificationController extends Controller
{

}
