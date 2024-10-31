<?php

namespace App\Http\Controllers\API\Address;

use App\Http\Controllers\Controller;
use App\Modules\Address\Domain\Models\Address;
use App\Modules\Address\Domain\Requests\Address\AddressCreateRequest;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function get(Request $Address)
    {
        $Address = Address::find($Address->input('id'));

        abort_unless( (bool) $Address , 404, "Такого адресса не существует.");

        return $Address;
    }

    public function create(AddressCreateRequest $request)
    {
        $validated = $request->validated();

        $Address = Address::factory()->create(
            $validated
        );

        return $Address;
    }
}
