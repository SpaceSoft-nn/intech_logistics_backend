<?php

namespace App\Http\Controllers\API\Transfer;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Transfer\App\Data\DTO\Transfer\CreateTransferServiceDTO;
use App\Modules\Transfer\App\Data\DTO\Transfer\TransferDTO;
use App\Modules\Transfer\Domain\Models\Transfer;
use App\Modules\Transfer\Domain\Requests\TransferCreateRequest;
use App\Modules\Transfer\Domain\Resources\TransferCollection;
use App\Modules\Transfer\Domain\Resources\TransferResource;
use App\Modules\Transfer\Domain\Services\TransferService;
use App\Modules\Transport\Domain\Models\Transport;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class TransferContoller
{

    public function index()
    {

        $transfer = Transfer::all();

        return response()->json(array_success(TransferCollection::make($transfer), 'Return all Transfers.'), 200);
    }

    public function show(Transfer $transfer)
    {


        dd($transfer->agreements);

        return response()->json(array_success(TransferResource::make($transfer), 'Return Transfer.'), 200);
    }

    public function create(

        TransferCreateRequest $request,
        TransferService $transferService,

    ) {

        $validated = $request->validated();


        $transfer = $transferService->createTransfer(
            CreateTransferServiceDTO::make(
                main_order_id: $validated['main_order'],
                agreementOrder_id: $validated['agreement_order_accept_id'],
                transferDTO: TransferDTO::make(
                    transport_id: $validated['transport_id'],
                    description : $validated['description'],
                ),
            )
        );

        return $transfer
            ? response()->json(array_success(TransferResource::make($transfer), 'Return Transfer.'), 201)
            : response()->json(array_error(TransferResource::make($transfer), 'Error create transfer'), 404);
    }

}
