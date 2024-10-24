<?php

namespace App\Http\Controllers\API\Transfer;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Transfer\Domain\Models\Transfer;
use App\Modules\Transfer\Domain\Requests\TransferCreateRequest;
use App\Modules\Transfer\Domain\Resources\TransferCollection;
use App\Modules\Transfer\Domain\Resources\TransferResource;
use App\Modules\Transport\Domain\Models\Transport;

use function App\Helpers\array_success;

class TransferContoller
{

    public function get()
    {

        $transfer = Transfer::all();

        return response()->json(array_success(TransferCollection::make($transfer), 'Return Transfer.'), 200);
    }

    public function create(

        TransferCreateRequest $request,
        OrderUnitRepository $orderRepository,

    ) {
        //#TODO Проверять что agreement_order_accept_id и main_order (находятся в одной связи)
        $validated = $request->validated();

        {
            #TODO - вынести в сервес
            $model = AgreementOrderAccept::find($validated['agreement_order_accept_id']);
            if(!$model) { abort(404, "agreement_order_accept_id - Not Found"); }
            abort_unless( ($model->order_bool && $model->contractor_bool), 403, 'Стороны не согласовали документ.');
        }


        {
            /**
            * @var OrderUnit
            */
            $order_main = OrderUnit::find($validated['main_order']);
            abort_if(is_null($order_main),  404, 'Main order return null');
        }

        // {
        //     /**
        //     * @var OrderUnit
        //     */
        //     $orders = OrderUnit::find($validated['id_order_array']);
        //     abort_if(is_null($orders), 'Order array return null', 404);
        // }


        // //общая цена трансфера (все заказы)
        // $price = null;
        // $bodyVolume = null;

        // foreach ($orders as $order) {
        //     $price += $order->order_total;
        //     $bodyVolume += $order->body_volume;
        // }

        {
            //TODO Вынести назначение ТС в Request (Сделать создание TC)
            /**
            * @var Transport
            */
            $transport = Transport::first();
            // if($bodyVolume >= intval($transport->body_volume) ) { abort(400, 'У транспорта переполнен объём в 100м^3, относительно всех выбранных заказов'); }
        }

        $adress_start = $orderRepository->firstPivotPriorityAdress($order_main);
        $adress_end = $orderRepository->lastPivotPriorityAdress($order_main);


        $transferArray = [
            "transport_id" => $transport->id,
            "delivery_start" => $adress_start->order_units->first()->pivot->data_time, //Дата начало от Адресса (отпрвки)?
            "delivery_end" =>  $adress_end->order_units->first()->pivot->data_time,
            "adress_start_id" => $adress_start->id,
            "adress_end_id" => $adress_end->id,
            "order_total" => $order_main->order_total,
            "description" => "Сборка Общего Заказа",
            "body_volume" => $order_main->body_volume,
        ];

        $transfer = Transfer::create($transferArray);

        return response()->json(array_success(TransferResource::make($transfer), 'Return Transfer.'), 201);
    }

}
