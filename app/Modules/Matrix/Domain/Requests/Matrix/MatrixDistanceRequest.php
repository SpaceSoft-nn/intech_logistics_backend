<?php

namespace App\Modules\Matrix\Domain\Requests\Matrix;

use App\Modules\Base\Requests\ApiRequest;
use App\Modules\Matrix\App\Data\ValueObject\MatrixDistanceVO;

class MatrixDistanceRequest extends ApiRequest
{

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            'city_name_start' => ['required', 'string'],
            'city_name_end' => ['required', 'string'],

            'distance' => ['required' , 'numeric'],

            'city_start_gar_id' => ['nullable', 'uuid'],
            'city_end_gar_id' => ['nullable', 'uuid'],

        ];
    }


    public function createMatrixDistanceVO() : MatrixDistanceVO
    {
        return MatrixDistanceVO::fromArrayToObject($this->validated());
    }

}
