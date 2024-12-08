<?php

namespace App\Http\Controllers\API\Transport;

use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\Transport\Domain\Resources\TransportCollection;

use function App\Helpers\array_success;

class TransportController
{
    public function index()
    {
        $transports = Transport::get();

        return response()->json(array_success(TransportCollection::make($transports), 'Return all transports'), 200);
    }
}
