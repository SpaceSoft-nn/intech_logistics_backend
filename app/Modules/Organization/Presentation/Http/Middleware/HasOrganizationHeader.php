<?php

namespace App\Modules\Organization\Presentation\Http\Middleware;

use App\Modules\Organization\Domain\Models\Organization;
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
        $organization_id = $request->header('organization_id');

        // Проверяем, есть ли organization_id в заголовках
        abort_unless( (bool) $organization_id, 422, 'Для доступа к этому endpoint в header должено быть значение :{organization_id}');

        $organization = Organization::find($organization_id);

        abort_unless( $organization, 404, 'Организации не существует');

        //записываем организацию в атрибут, что бы не делать повторный запрос
        $request->attributes->set('organization', $organization);

        return $next($request);

    }
}
