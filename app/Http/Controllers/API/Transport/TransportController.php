<?php

namespace App\Http\Controllers\API\Transport;

use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\Domain\Actions\Transport\CreateTransportAction;
use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\Transport\Domain\Requests\TransportCreateRequest;
use App\Modules\Transport\Domain\Resources\TransportCollection;
use App\Modules\Transport\Domain\Resources\TransportResoruce;

use function App\Helpers\array_success;

class TransportController
{
    public function index(GetTypeCabinetByOrganization $action)
    {
        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        return $array['status'] ?
        response()->json(array_success(TransportCollection::make($organization->transports), 'Return all transports by organization Customer.'), 200)
            : response()->json(array_success(TransportCollection::make(Transport::all()), 'Return all transports.'), 200);
    }

    public function show(Transport $transport)
    {
        return response()->json(array_success(TransportResoruce::make($transport), 'Return object transport'), 200);
    }

    public function store(TransportCreateRequest $request)
    {


        /**
         * @var TransportVO
         */
        $transportVO = $request->createTransportVO();


        /**
        * @var Transport
        */
        $transport = CreateTransportAction::make($transportVO);

        return response()->json(array_success(TransportResoruce::make($transport), 'Return create transports'), 201);
    }
}
