<?php

namespace App\Http\Controllers\API\IndividualPeople\TypePeople;

use App\Http\Controllers\Controller;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\IndividualPeople\App\Data\DTO\CreateDriverPeopleDTO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Requests\TypePeoples\CreateDriverPeopleRequest;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\DriverPeopleCollection;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\DriverPeopleResource;
use App\Modules\IndividualPeople\Domain\Services\TypePeople\DriverPeopleService;
use App\Modules\Organization\Domain\Models\Organization;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class DriverPeopleController extends Controller
{

    public function index(GetTypeCabinetByOrganization $action)
    {

        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        return $array['status'] ?
        response()->json(array_success(DriverPeopleCollection::make($organization->drivers), 'Return all drevirs by organization Customer.'), 200)
            : response()->json(array_success(DriverPeopleCollection::make(DriverPeople::all()), 'Return all drevirs.'), 200);
    }


    public function show(
        DriverPeople $driverPeople
    ) {
        return response()->json(array_success(DriverPeopleResource::make($driverPeople), 'Return driver people for uuid.'), 200);
    }

    public function store(
        CreateDriverPeopleRequest $request,
        DriverPeopleService $service,
    ) {

        /**
         * @var CreateDriverPeopleDTO
         */
        $createDriverPeopleDTO = $request->createDriverPeopleDTO();



        /** @var DriverPeople */
        $model = $service->createDriverPeople($createDriverPeopleDTO);

        return $model ?
            response()->json(array_success(DriverPeopleResource::make($model), 'Create driver people.'), 201)
            :
            response()->json(array_error(DriverPeopleResource::make($model), 'Faild create driver people.'), 404);
    }


}
