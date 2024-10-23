<?php

namespace App\Http\Controllers\API\Transfer;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Transfer\Domain\Models\Transfer;
use App\Modules\Transfer\Domain\Requests\TransferCreateRequest;
use App\Modules\Transfer\Domain\Resources\TransferResource;
use App\Modules\Transport\Domain\Models\Transport;

use function App\Helpers\array_success;

class TransferContoller
{

    public function create(

        TransferCreateRequest $request,
        OrderUnitRepository $orderRepository,

    ) {
        $validated = $request->validated();


        {
            #TODO - вынести в сервес
            $model = AgreementOrderAccept::find($validated['agreement_order_accept_id']);
            abort_unless( ($model->order_bool && $model->contractor_bool), 403, 'Стороны не согласовали документ.');
        }

        {
            /**
            * @var OrderUnit
            */
            $order_main = OrderUnit::find($validated['main_order']);
            abort_if(is_null($order_main), 'Main order return null', 404);
        }

        dd($orderRepository->firstPivotPriorityAdress($order_main));


        {
            /**
            * @var OrderUnit
            */
            $orders = OrderUnit::find($validated['id_order_array']);
            abort_if(is_null($orders), 'Order array return null', 404);
        }


        //общая цена трансфера (все заказы)
        $price = null;
        $bodyVolume = null;

        foreach ($orders as $order) {
            $price += $order->order_total;
            $bodyVolume += $order->body_volume;
        }

        {
            /**
            * @var Transport
            */
            $transport = Transport::first();
            if($bodyVolume >= intval($transport->body_volume) ) { abort(400, 'У транспорта переполнен объём в 100м^3, относительно всех выбранных заказов'); }
        }
        //
        $transferArray = [
            "transport_id" => $transport->id,
            "delivery_start" => $order_main->delivery_start,
            "delivery_end" => $order_main->delivery_end,
            "adress_start_id" => $order_main->adress_start_id,
            "adress_end_id" => $order_main->adress_end_id,
            "order_total" => $price,
            "description" => "Сборка Общего Заказа",
            "body_volume" => $bodyVolume,
        ];

        $transfer = Transfer::create($transferArray);

        return response()->json(array_success(TransferResource::make($transfer), 'Return Transfer.'), 201);
    }

}
