<?php

use App\Modules\Organization\Presentation\Http\Middleware\HasOrganizationHeader;
use App\Modules\Organization\Presentation\Http\Middleware\isCarrierOrganization;
use App\Modules\Organization\Presentation\Http\Middleware\isCustomerOrganization;
use App\Modules\User\Presentation\HTTP\Middleware\isActiveUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->use([
            \Illuminate\Foundation\Http\Middleware\InvokeDeferredCallbacks::class,
            // \Illuminate\Http\Middleware\TrustHosts::class,
            \Illuminate\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Http\Middleware\ValidatePostSize::class,
            \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);

        $middleware->alias([
            'isCustomerOrganization' => isCustomerOrganization::class, //Проверяет связку организация + пользователь и организация типа Customer 'заказчик'
            'isCarrierOrganization' => isCarrierOrganization::class, //Проверяет связку организация + пользователь и организация типа Carrier 'перевозчик'
            'hasOrgHeader' => HasOrganizationHeader::class, //Проверяет связку организация + пользователь и организация типа Carrier 'перевозчик'
            'isActiveUser' => isActiveUser::class, //Активирован ли user user->active
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Exception $ex) {

            //Для ошибок Exception - и коде 500, присылаем минимальную информацию
            // if($ex->getCode() === 500)
            // {
            //     return response()->json([
            //         'message' => 'Внутренняя Ошибка Сервера'
            //     ], 500);
            // }

        });

    })->create();
