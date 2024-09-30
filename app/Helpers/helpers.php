<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


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
        return (string) Str::uuid();
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





