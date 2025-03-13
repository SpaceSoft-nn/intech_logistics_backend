<?php

namespace App\Modules\Organization\Presentation\Http\Middleware;

use App\Modules\Organization\Domain\Models\Organization;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class ManuallyActivatedOrganization
{

    /** Устанавливаем организацию в remuved = true при создании орг, и ждём пока мы активируем сами через БД */
    public function handle(
        Request $request,
        Closure $next,

    ): Response {

        #TODD - вынести в отдельный middleware и создать группу middleware
        $organization_id = $request->header('organization_id');

        // Проверяем, есть ли organization_id в заголовках
        abort_unless( (bool) $organization_id, 422, 'Для доступа к этому endpoint в header должено быть значение :{organization_id}');

        $organization = Organization::find($organization_id);


        // dd($organization->remuved);

        abort_if( $organization->remuved , 403, 'Организация не активирована, попросите Администраторов проекта, активировать организацию.');

        return $next($request);

    }
}
