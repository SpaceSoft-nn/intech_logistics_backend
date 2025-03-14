<?php

namespace App\Http\Controllers\API\IndividualPeople;

use App\Http\Controllers\Controller;
use function App\Helpers\array_error;
use function App\Helpers\array_success;
use App\Modules\IndividualPeople\App\Data\DTO\Base\BaseDTO;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\IndividualPeople\Domain\Services\IndividualPeopleService;
use App\Modules\IndividualPeople\Domain\Resources\IndividualPeopleResource;

use App\Modules\IndividualPeople\Domain\Resources\IndividualPeopleCollection;
use App\Modules\IndividualPeople\Domain\Requests\CreateIndividualPeopleRequest;

class IndividualPeopleController extends Controller
{

    public function index()
    {
        $model = IndividualPeople::all();

        return response()->json(array_success(IndividualPeopleCollection::make($model), 'Return all individual people.'), 200);
    }


    public function show(
        IndividualPeople $individualPeople
    ) {
        return response()->json(array_success(IndividualPeopleResource::make($individualPeople), 'Return individual people for uuid.'), 200);
    }


    public function store(
        CreateIndividualPeopleRequest $request,
        IndividualPeopleService $service,
    ) {

        /**
        * @var BaseDTO
        */
        $dto = $request->createCreateIndividualPeopleDTO();


        /**
        * @var IndividualPeople
        */
        $model = $service->createIndividualPeople($dto);


        return $model ?
        response()->json(array_success(IndividualPeopleResource::make($model), 'Create individual people.'), 201)
        :
        response()->json(array_error(IndividualPeopleResource::make($model), 'Faild create individual people.'), 404);

    }


}
