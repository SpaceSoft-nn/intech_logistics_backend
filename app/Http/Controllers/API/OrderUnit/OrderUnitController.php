<?php

namespace App\Http\Controllers\API\OrderUnit;

use App\Http\Controllers\Controller;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OredUnitCollection;
use Illuminate\Http\Request;

use function App\Helpers\array_success;

class OrderUnitController extends Controller
{
    /**
     * Вернуть все заказы
     */
    public function get(Request $request)
    {
        /**
        * @var OrderUnit[]
        */
        $order = OrderUnit::all();

        return response()->json(array_success(OredUnitCollection::make($order), 'Return Order.'), 200);
    }
}
