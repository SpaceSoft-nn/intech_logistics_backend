<?php

namespace App\Modules\OfferContractor\Domain\Requests;

use App\Http\Controllers\Swagger\API\OfferContractor;
use Illuminate\Validation\Rule;
use App\Modules\Base\Requests\ApiRequest;
use App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Models\OfferContractor as ModelsOfferContractor;

class UpdateOfferContractorRequest extends ApiRequest
{
    //Сохраняем состояние валидации 1 раз, что бы не вызывать её множество раз при создании VO
    private array $validatedData = [];

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        #TODO Моного запросов в бд в validation*
        // Получаем названия всех кейсов
        $typeLoadingTruckMethod = array_column(OfferContractorStatusEnum::cases(), 'name');


        return [

            'city_name_start' => ['sometimes', 'string' , 'min:2'],
            'city_name_end' => ['sometimes', 'string', 'min:2'],
            'price_for_distance' => ['sometimes', 'numeric'],
            'transport_id' => ['sometimes', 'uuid', 'exists:transports,id'],
            'add_load_space' => ['sometimes', 'boolean'],
            'road_back' => ['sometimes', 'boolean'],
            'directly_road' => ['sometimes', 'boolean'],
            'description' => ['sometimes', 'string', "max:1000"],
            'status' => ['sometimes', 'string', Rule::in($typeLoadingTruckMethod)]

        ];
    }

    /**
    * Получить или сохранить валидированные данные.
    *
    * @return array
    */
    private function getValidatedData(): array
    {
        if (empty($this->validatedData)) {
            $this->validatedData = $this->validated();
        }

        return $this->validatedData;
    }


    public function fromArrayToObjectForModel(ModelsOfferContractor $offer) : OfferContractorVO
    {
        return OfferContractorVO::fromArrayToObjectForModel($offer, $this->getValidatedData());
    }



}
