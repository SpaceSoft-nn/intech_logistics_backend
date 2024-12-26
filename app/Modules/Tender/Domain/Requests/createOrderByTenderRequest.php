<?php

namespace App\Modules\Tender\Domain\Requests;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\OrderUnit\App\Data\Enums\TypeTransportWeight;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rule;

class CreateLotTenderRequest extends ApiRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {


        return [



        ];


    }



}
