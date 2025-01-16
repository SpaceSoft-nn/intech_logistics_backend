<?php

namespace App\Http\Controllers\API\Avizo;

use App\Modules\Avizo\App\Data\ValueObject\AvizoPhoneVO;
use App\Modules\Avizo\Domain\Models\AvizoPhone;
use App\Modules\Avizo\Domain\Requests\AvizoPhone\ConfirmAvizoPhoneRequest;
use App\Modules\Avizo\Domain\Requests\AvizoPhone\CreateAvizoPhoneRequest;
use App\Modules\Avizo\Domain\Services\AvizoPhoneService;
use App\Modules\Base\Error\BusinessException;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class AvizoPhoneController
{
    public function store(
        CreateAvizoPhoneRequest $request,
        AvizoPhoneService $service,
    ) {

        /** @var AvizoPhoneVO */
        $avizoPhoneVO =  $request->createAvisoEmailVO();

        $model = $service->createAvizoPhone($avizoPhoneVO);

        return ($model)
            ? response()->json(array_success(null, 'Succesefull - create Avizo and send.'), 201)
            : response()->json(array_error(null, 'Error - Avizo and send.'), 404);
    }

    public function confirm(
        ConfirmAvizoPhoneRequest $request,
        AvizoPhoneService $service,
    ) {

        #todo пересмотреть логика кода код может в бд повториться.

        $validated = $request->validated();

        $avizoPhone = AvizoPhone::where('code',  $validated['code_confirm'])->first();

        if(is_null($avizoPhone)) {  throw new BusinessException('Код активации не верный.'); }

        $status = $service->confirmation($avizoPhone);

        return ($status)
            ? response()->json(array_success(null, 'Was confirmed'), 200)
            : response()->json(array_error(null, 'Error confirmed'), 404);
    }
}

