<?php

use App\Modules\Organization\Presentation\Http\Middleware\HasOrganizationHeader;
use App\Modules\Organization\Presentation\Http\Middleware\isCarrierOrganization;
use App\Modules\Organization\Presentation\Http\Middleware\isCustomerOrganization;
use App\Modules\Organization\Presentation\Http\Middleware\ManuallyActivatedOrganization;
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
            'manuallyActivatedOrganization' => ManuallyActivatedOrganization::class, //Активирована ли организация в проекте вручную
        ]);

        $middleware->prependToGroup('organizaionGroupMiddleware', [
            ManuallyActivatedOrganization::class,
            HasOrganizationHeader::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (Exception $e) {

                if ($e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) {
                    $status = $e->getStatusCode();
                } else {
                    $status = 500;
                }

                if ($status === 500) {
                    return;
                }

                return response()->json([
                    'error' => $e->getMessage(),
                    'code'  => $e->getCode() ?: $status
                ], $status);

            });

    })->withMiddleware(function (Middleware $middleware) {
        $middleware->priority([
            \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
            \Illuminate\Auth\Middleware\Authorize::class,
            isCustomerOrganization::class, //Проверяет связку организация + пользователь и организация типа Customer 'заказчик'
            isCarrierOrganization::class, //Проверяет связку организация + пользователь и организация типа Carrier 'перевозчик'
            HasOrganizationHeader::class, //Проверяет есть ли в header org
            isActiveUser::class, //Активирован ли user user->active
            ManuallyActivatedOrganization::class, //Активирована ли организация в проекте вручную
        ]);
    })
    ->create();
