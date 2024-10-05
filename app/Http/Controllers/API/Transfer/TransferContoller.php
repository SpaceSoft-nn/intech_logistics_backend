<?php

namespace App\Http\Controllers\API\Transfer;

use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Transfer\Domain\Requests\TransferCreateRequest;

class TransferContoller
{

    public function create(TransferCreateRequest $request)
    {
        $validated = $request->validated();

        /**
        * @var OrderUnit
        */
        $orders = OrderUnit::find($validated['id_order_array']);

        dd($orders);
    }

}
