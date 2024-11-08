<?php

namespace App\Modules\OrderUnit\Domain\Rule;

use App\Modules\PalletSpace\App\Data\Enums\TypeSizePalletSpaceEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArrayCargoGoodRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // Проверяем, что значение является массивом
        if (!is_array($value)) {
            $fail('Ошибка :attribute должен быть массивом.');
            return;
        }

        $messagesBagError = [
            'key.uuid' => 'Указанный :attribute ключ не является корректным UUID.',
            'key.date' => 'Указанное :attribute значение ключа не является верным форматом DATE',
        ];

        $typeTransportWeight = array_column(TypeSizePalletSpaceEnum::cases(), 'name');

        foreach($value as $subArray){

            dd($subArray);

            $validator = Validator::make(
                [
                    'name_value' => $date,
                    'product_type' => $date,
                    'cargo_units_count' => $date,
                    'body_bolume' => $date,
                    'description' => $date,
                ],
                [
                    'product_type' => 'required|string',
                    'type_pallet' => ['required', 'string', Rule::in($typeTransportWeight)],
                    'cargo_units_count' => 'required|integer|min:1',
                    'body_bolume' => 'required|numeric|min:0',
                    'name_value' => 'nullable|string|max:100',
                    'description' => 'nullable|string|max:500',
                ]
            ,$messagesBagError);

            if ($validator->fails()) {
                //Здесь будут использованы пользовательские сообщения
                $errors = $validator->errors()->all();
                $fail(implode(', ', $errors));
                return;
            }

        }

    }

}
