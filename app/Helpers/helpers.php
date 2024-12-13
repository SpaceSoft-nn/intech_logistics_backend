<?php

namespace App\Helpers;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\User\Domain\Models\User;
use DateTime;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

if (!function_exists('array_error'))
{
    function array_error($data = null , string $message = 'error') : array
    {
        //mb_convert_encoding для кодировки строки из (полученной mb_detect_encoding() в utf-8)
        return [
            'data' => $data,
            'message' => mb_convert_encoding($message, 'utf-8', mb_detect_encoding($message)),
        ];

    }
}

if (!function_exists('array_success'))
{
    //Response helpers
    function array_success($data = null , string $message = 'success') : array
    {
        //mb_convert_encoding для кодировки строки из (полученной mb_detect_encoding() в utf-8)
        return [
            'data' => $data,
            'message' => mb_convert_encoding($message, 'utf-8', mb_detect_encoding($message)),
        ];

    }
}

if (!function_exists('uuid'))
{
    function uuid(string $path = '') : string
    {

        /**
         * Добавлен uuid v6 за место v4, т.к у v6 есть сортировка прямо в начале записи по времени,
         * и можно будет отсортирововать в бд по uuid более правильно, но не стоит забывать про подводные
         * камни и колизии, например если есть несколько серверов с разным серверным временем
         */
        return Uuid::uuid6()->toString();
    }
}

if (!function_exists('Mylog'))
{
    function Mylog(string $message) : void
    {
        $backtrace = debug_backtrace();
        // Извлекаем информацию о вызове для уровня выше функции myFunction, то есть самого вызывающего.
        $caller = $backtrace[1];

        Log::info($message . ' ' . now() . " ------> " . 'Debug backtrace: ' . 'Function called from file: ' . $caller['file'] . ' on line ' . $caller['line']);
    }
}

if (!function_exists('isAuthorized'))
{
    function isAuthorized(AuthServiceInterface $authService) : User
    {
        /**
        * получаем авторизированного user
        * @var User
        */

        $user = $authService->getUserAuth();

        abort_unless( (bool) $user, 401, "Не авторизован");

        return $user;
    }
}

if (!function_exists('add_time_random'))
{
    function add_time_random(DateTime|string $data_time, int $daysToAdd = null) :  string
    {
        if(is_string($data_time)) { $data_time =  new DateTime($data_time); }

        // Вычислите конечную дату, добавив количество дней к начальному дню
        // Вы также можете заменить $daysToAdd на конкретное количество дней или сделать их рандомным значением
        if(is_null($daysToAdd)) { $daysToAdd = random_int(1, 30); }
        $deliveryEnd = $data_time->modify("+$daysToAdd days")->format('Y-m-d H:i:s');

        return $deliveryEnd;
    }
}








