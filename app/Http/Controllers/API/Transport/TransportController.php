<?php

namespace App\Http\Controllers\API\Transport;

use Illuminate\Http\Request;
use function App\Helpers\array_error;
use function App\Helpers\array_success;
use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Transport\Domain\Resources\TransportResource;
use App\Modules\Transport\App\Data\DTO\ValueObject\TransportVO;
use App\Modules\Transport\Domain\Resources\TransportCollection;

use App\Modules\Transport\Domain\Requests\TransportCreateRequest;
use App\Modules\Transport\Domain\Actions\Transport\CreateTransportAction;
use App\Modules\Transport\Domain\Actions\Transport\UpdateTransportAction;
use App\Modules\Transport\Domain\Requests\TransportUpdateRequest;

class TransportController
{
    public function index(Request $request)
    {
        /** @var Organization */ //p.s устанавливаем значение в middleware
        $organization = $request->attributes->get('organization');

        abort_unless( $organization, 404, 'Организации не существует');

        return $organization->transports ?
        response()->json(array_success(TransportCollection::make($organization->transports), 'Return all transports by organization Customer.'), 200)
            : response()->json(array_error(null, 'Faild return drivers people.'), 404);
    }

    public function show(Transport $transport)
    {
        return response()->json(array_success(TransportResource::make($transport), 'Return object transport'), 200);
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

        return response()->json(array_success(TransportResource::make($transport), 'Return create transports'), 201);
    }

    public function update(
        Transport $transport,
        TransportUpdateRequest $request
    ) {

        /**
         * @var TransportVO
         */
        $transportVO = $request->updateTransportVO($transport);

        /**
        * @var Transport
        */
        $transport = UpdateTransportAction::make($transportVO, $transport);

        return response()->json(array_success(TransportResource::make($transport), 'Successfully updated transport'), 200);
    }
}
