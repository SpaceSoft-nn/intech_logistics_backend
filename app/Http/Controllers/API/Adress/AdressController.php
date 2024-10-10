<?php

namespace App\Http\Controllers\API\Adress;

use App\Http\Controllers\Controller;
use App\Modules\Adress\Domain\Models\Adress;
use App\Modules\Adress\Domain\Requests\Adress\AdressCreateRequest;
use Illuminate\Http\Request;

class AdressController extends Controller
{

    public function get(Request $adress)
    {
        $adress = Adress::find($adress->input('id'));

        abort_unless( (bool) $adress , 404, "Такого адресса не существует.");

        return $adress;
    }

    public function create(AdressCreateRequest $request)
    {
        $validated = $request->validated();

        $adress = Adress::factory()->create(
            $validated
        );

        return $adress;
    }
}
