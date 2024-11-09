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


        $typeTransportWeight = array_column(TypeSizePalletSpaceEnum::cases(), 'name');

        // $messageBagMgx = [
        //     'mgx.array' => 'Поле MGX должно быть массивом.',
        //     'mgx.height' => 'Поле MGX должно быть массивом.',
        //     'mgx.array' => 'Поле MGX должно быть массивом.',
        // ];

        foreach($value as $key){

            $validatorGood = Validator::make(

                [
                    'name_value' => $key['name_value'],
                    'product_type' => $key['product_type'],
                    'type_pallet' => $key['type_pallet'],
                    'cargo_units_count' => $key['cargo_units_count'],
                    'body_bolume' => $key['body_bolume'],
                    'description' => $key['description'],
                    'mgx' => $key['mgx'],
                ],

                [
                    'product_type' => ['required' ,'string'],
                    'type_pallet' => ['required', 'string', Rule::in($typeTransportWeight)],
                    'cargo_units_count' => ['required', 'integer', 'min:1'],
                    'body_bolume' => ['required','numeric', 'min:0'],
                    'name_value' => ['nullable', 'string', 'max:100'],
                    'description' => ['nullable', 'string' , 'max:500'],
                    'mgx' => ['nullable', 'array', new ArrayCargoMgxRule()],
                ],

                [
                    'mgx.length.required' => 'Поле Длина обязательно для заполнения.',
                    'mgx.length.numeric' => 'Поле Длина должно быть числом.',
                    'mgx.length.min' => 'Поле Длина должно быть не меньше 0.',

                    'mgx.width.required' => 'Поле Ширина обязательно для заполнения.',
                    'mgx.width.numeric' => 'Поле Ширина должно быть числом.',
                    'mgx.width.min' => 'Поле Ширина должно быть не меньше 0.',

                    'mgx.height.required' => 'Поле Высота обязательно для заполнения.',
                    'mgx.height.numeric' => 'Поле Высота должно быть числом.',
                    'mgx.height.min' => 'Поле Высота должно быть не меньше 0.',

                    'mgx.weight.required' => 'Поле Вес обязательно для заполнения.',
                    'mgx.weight.numeric' => 'Поле Вес должно быть числом.',
                    'mgx.weight.min' => 'Поле Вес должно быть не меньше 0.',
                ]
            );


            if ($validatorGood->fails()) {


                //Здесь будут использованы пользовательские сообщения
                $errors = $validatorGood->errors()->all();
                $fail(implode(', ', $errors));
                return;
            }


        }

    }

}
