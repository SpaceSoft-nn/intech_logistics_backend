<?php

namespace App\Http\Controllers\API\Avizo;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use App\Modules\Avizo\Domain\Models\AvizoEmail;
use App\Modules\Avizo\App\Data\ValueObject\AvizoEmailVO;

use App\Modules\Avizo\Domain\Services\AvizoEmailSerivce;
use App\Modules\Avizo\Domain\Requests\AvizoEmail\CreateAvizoEmailRequest;

class AvizoEmailController
{
    public function store(
        CreateAvizoEmailRequest $request,
        AvizoEmailSerivce $service,
    ) {

        /** @var AvizoEmailVO */
        $avizoEmailVO = $request->createAvisoEmailVO();

        $model = $service->createAvizoEmail($avizoEmailVO);

        return ($model)
            ? response()->json(array_success(null, 'Succesefull - create Avizo and send.'), 201)
            : response()->json(array_error(null, 'Error - Avizo and send.'), 404);
    }

    public function confirm(
        string $uuid,
        AvizoEmailSerivce $service,
    ) {

        /** @var AvizoEmail */
        $avizo = AvizoEmail::where('uuid', $uuid)->first();

        abort_unless($avizo, 404);

        $status = $service->confirmation($avizo);

        return ($status)
            ? response()->json(array_success(null, 'Was confirmed'), 200)
            : response()->json(array_error(null, 'Error confirmed'), 404);
    }
}
