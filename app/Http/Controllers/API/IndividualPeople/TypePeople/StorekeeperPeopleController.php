<?php

namespace App\Http\Controllers\API\IndividualPeople\TypePeople;

use App\Http\Controllers\Controller;
use App\Modules\IndividualPeople\App\Data\ValueObject\DriverPeopleVO;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\StorekeeperPeople;
use App\Modules\IndividualPeople\Domain\Requests\TypePeoples\CreateDriverPeopleRequest;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\DriverPeopleCollection;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\DriverPeopleResource;
use App\Modules\IndividualPeople\Domain\Services\TypePeople\DriverPeopleService;
use App\Modules\IndividualPeople\Domain\Services\TypePeople\StorekeeperPeopleService;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class StorekeeperPeopleController extends Controller
{

    public function index()
    {
        $driverPeoples = StorekeeperPeople::all();

        return response()->json(array_success(DriverPeopleCollection::make($driverPeoples), 'Return all storekeeper people.'), 200);
    }


    public function show(
        StorekeeperPeople $storekeeperPeople
    ) {
        return response()->json(array_success(DriverPeopleResource::make($storekeeperPeople), 'Return storekeeper people for uuid.'), 200);
    }

    public function store(
        CreateDriverPeopleRequest $request,
        StorekeeperPeopleService $service,
    ) {

        /**
         * @var StorekeeperPeopleVO
         */
        $storekeeperPeopleVO = $request->createDriverPeopleVO();

        $model = $service->createStorekeeperPeople($storekeeperPeopleVO);

        return $model ?
            response()->json(array_success(DriverPeopleResource::make($model), 'Create driver people.'), 201)
            :
            response()->json(array_error(DriverPeopleResource::make($model), 'Faild create driver people.'), 404);
    }


}
