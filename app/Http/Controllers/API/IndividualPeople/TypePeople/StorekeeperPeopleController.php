<?php

namespace App\Http\Controllers\API\IndividualPeople\TypePeople;

use App\Http\Controllers\Controller;
use App\Modules\IndividualPeople\App\Data\DTO\CreateStorekeeperPeopleDTO;
use App\Modules\IndividualPeople\App\Data\ValueObject\StorekeeperPeopleVO;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\DriverPeopleResource;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\DriverPeopleCollection;
use App\Modules\IndividualPeople\Domain\Services\TypePeople\StorekeeperPeopleService;
use App\Modules\IndividualPeople\Domain\Requests\TypePeoples\CreateStorekeeperPeopleRequest;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\StorekeeperPeopleCollection;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\StorekeeperPeopleResource;

class StorekeeperPeopleController extends Controller
{

    public function index()
    {
        $driverPeoples = StorekeeperPeople::all();

        return response()->json(array_success(StorekeeperPeopleCollection::make($driverPeoples), 'Return all storekeeper people.'), 200);
    }


    public function show(
        StorekeeperPeople $storekeeperPeople
    ) {
        return response()->json(array_success(StorekeeperPeopleResource::make($storekeeperPeople), 'Return storekeeper people for uuid.'), 200);
    }

    public function store(
        CreateStorekeeperPeopleRequest $request,
        StorekeeperPeopleService $service,
    ) {

        /**
         * @var CreateStorekeeperPeopleDTO
         */
        $createStorekeeperPeopleDTO = $request->createStorekeeperPeopleDTO();

        $model = $service->createStorekeeperPeople($createStorekeeperPeopleDTO);

        return $model ?
            response()->json(array_success(StorekeeperPeopleResource::make($model), 'Create storekeeper people.'), 201)
            :
            response()->json(array_error(null, 'Faild create storekeeper people.'), 404);
    }


}
