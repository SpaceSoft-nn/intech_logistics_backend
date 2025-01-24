<?php

namespace App\Modules\Organization\Presentation\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class HasOrganizationHeader
{

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,

    ): Response {

        #TODD - вынести в отдельный middleware и создать группу middleware
        $organizationId = $request->header('organization_id');

        // Проверяем, есть ли organization_id в заголовках
        abort_unless( (bool) $organizationId, 422, 'Для доступа к этому endpoint в header должено быть значение :{organization_id}');

        return $next($request);
    }
}
