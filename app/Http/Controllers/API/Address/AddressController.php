<?php

namespace App\Http\Controllers\API\Address;

use App\Http\Controllers\Controller;
use App\Modules\Address\App\Data\DTO\ValueObject\AddressVO;
use App\Modules\Address\Domain\Actions\Address\CreateAddressAction;
use App\Modules\Address\Domain\Models\Address;
use App\Modules\Address\Domain\Requests\Address\AddressCreateRequest;
use App\Modules\Address\Domain\Resources\AddressCollection;
use App\Modules\Address\Domain\Resources\AddressResource;

use function App\Helpers\array_success;

class AddressController extends Controller
{

    public function index()  {

        return response()->json(array_success(AddressCollection::make(Address::all()), 'Return create Address.'), 201);
    }

    public function show(Address $address)
    {
        return response()->json(array_success(AddressResource::make($address), 'Return create Address.'), 200);
    }

    public function create(
        AddressCreateRequest $request,
        CreateAddressAction $action,
    )  {


        /**
        * @var AddressVO
        */
        $addressVO = $request->getAddressVO();


        $address = $action->make($addressVO);

        return response()->json(array_success(AddressResource::make($address), 'Return create Address.'), 201);
    }
}
