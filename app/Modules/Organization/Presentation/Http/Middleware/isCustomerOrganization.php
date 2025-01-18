<?php

namespace App\Modules\Organization\Presentation\Http\Middleware;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function App\Helpers\isAuthorized;

class isCustomerOrganization
{

    protected AuthServiceInterface $auth;
    protected OrganizationRepository $repOrg;

    // Инъекция зависимости через конструктор
    public function __construct(
        AuthService $auth,
        OrganizationRepository $repOrg,
    ) {
        $this->auth = $auth;
        $this->repOrg = $repOrg;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(
        Request $request,
        Closure $next,

    ): Response {

        /** @var User */
        $user = isAuthorized($this->auth);


        #TODD - вынести в отдельный middleware и создать группу middleware
        $organizationId = $request->header('organization_id');


        // Проверяем, есть ли organization_id в заголовках
        abort_unless( (bool) $organizationId, 422, 'Для доступа к этому endpoint в header должено быть значение :{organization_id}');


        /** @var Organization */
        $organization = $user->organizations->firstWhere('id', $organizationId);

        // Проверяем, есть ли organization_id в заголовках
        abort_unless( (bool) $organization, 401, 'Данный пользователь не относится к этой Organization');

        /** @var TypeCabinetEnum */
        $typeCabinet = $this->repOrg->getTypeCabinet($user, $organization);

        //выкидываем ошибку - если организация не перевозчитк
        abort_unless( (bool) TypeCabinetEnum::isCustomer($typeCabinet)  , 422, 'Организация не является заказчиком.' );

        return $next($request);
    }
}
