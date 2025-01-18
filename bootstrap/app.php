<?php

use App\Modules\Organization\Presentation\Http\Middleware\isCustomerOrganization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'isCustomerOrganization' => isCustomerOrganization::class //Проверяет связку организация + пользователь и организация типа Customer 'заказчик'
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
