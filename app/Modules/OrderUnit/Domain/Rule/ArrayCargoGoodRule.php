<?php

namespace App\Modules\OrderUnit\Domain\Rule;

use Closure;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;

class ArrayCargoGoodRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // Проверяем, что значение является массивом
        if (!is_array($value)) {
            $fail('Ошибка :attribute должен быть массивом.');
            return;
        }


        $typePallet = array_column(TypeSizePalletSpaceEnum::cases(), 'name');

        $messageBagGood = [
           'product_type' => [
                'required' => "Поле :attribute обязательно для заполнения.",
                'string' => ":attribute должен быть строкой."
            ],
            'type_pallet' => [
                'required' => "Поле :attribute обязательно для заполнения.",
                'string' => ":attribute должен быть строкой.",
                'in' => "Выбранный :attribute недействителен." // если значение не содержится в массиве $typeTransportWeight
            ],
            'cargo_units_count' => [
                'required' => "Поле :attribute обязательно для заполнения.",
                'integer' => ":attribute должно быть целым числом.",
                'min' => ":attribute должно быть не менее 1."
            ],
            'body_volume' => [
                'required' => "Поле :attribute обязательно для заполнения.",
                'numeric' => ":attribute должен быть числом.",
                'min' => ":attribute должен быть не менее 0.", // возможно, 0 допустимо
                'max' => ":attribute должен быть не более 270.",
            ],
            'name_value' => [
                'string' => ":attribute должно быть строкой.",
                'max' => ":attribute не должно превышать 100 символов." // если передан не null и превышает 100 символов
            ],
            'description' => [
                'string' => ":attribute должен быть строкой.",
                'max' => ":attribute не должнен превышать 500 символов." // если передан не null и превышает 500 символов
            ],
            'weight_general' => [
                'required' => 'Поле :attribute обязательно для заполнения.',
                'numeric' => 'Поле :attribute должно быть числом.',
                'min' => 'Поле :attribute должно быть не меньше 0.',
            ]

    ];

        foreach($value as $key){

            $validatorGood = Validator::make(

                [
                    'name_value' => $key['name_value'] ?? null,
                    'product_type' => $key['product_type'] ?? null,
                    'type_pallet' => $key['type_pallet'] ?? null,
                    'cargo_units_count' => $key['cargo_units_count'] ?? null,
                    'body_volume' => $key['body_volume'] ?? null,
                    'description' => $key['description'] ?? null,
                    'weight_general' => $key['weight_general'] ?? null,
                    'mgx' => $key['mgx'] ?? null,
                ],

                [
                    'product_type' => ['required' ,'string'],
                    'type_pallet' => ['required', 'string', Rule::in($typePallet)],
                    'cargo_units_count' => ['required', 'integer', 'min:1'],
                    'body_volume' => ['required','numeric', 'min:0', 'max:270'],
                    'weight_general' => ['required', 'numeric', 'min:0'],
                    'name_value' => ['nullable', 'string', 'max:100'],
                    'description' => ['nullable', 'string' , 'max:500'],
                    'mgx' => ['nullable', new ArrayCargoMgxRule()],
                ], $messageBagGood );


            if ($validatorGood->fails()) {


                //Здесь будут использованы пользовательские сообщения
                $errors = $validatorGood->errors()->all();
                $fail(implode(', ', $errors));
                return;
            }


        }

    }

}
