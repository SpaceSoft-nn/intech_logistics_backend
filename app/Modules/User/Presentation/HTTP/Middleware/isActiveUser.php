<?php

namespace App\Modules\User\Presentation\HTTP\Middleware;

use Closure;
use Illuminate\Http\Request;
use function App\Helpers\isAuthorized;
use App\Modules\User\Domain\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Auth\Domain\Interface\AuthServiceInterface;


class isActiveUser
{

    protected AuthServiceInterface $auth;

    // Инъекция зависимости через конструктор
    public function __construct(
        AuthService $auth,
    ) {
        $this->auth = $auth;
    }

    public function handle(
        Request $request,
        Closure $next,
    ): Response {

        /** @var User */
        $user = isAuthorized($this->auth);

        // Проверяем, есть ли organization_id в заголовках
        abort_unless( (bool) $user->active, 422, 'Данный user не активирован.');

        return $next($request);
    }
}
