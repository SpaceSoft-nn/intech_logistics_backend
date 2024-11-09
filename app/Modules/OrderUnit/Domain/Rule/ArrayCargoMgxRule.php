<?php

namespace App\Modules\OrderUnit\Domain\Rule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class ArrayCargoMgxRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        // Проверяем, что значение является массивом
        if (!is_array($value)) {
            $fail('Ошибка :attribute должен быть массивом.');

            return;
        }


        $validatorGood = Validator::make(
            [
                "length" => Arr::get($value , 'length', ""),
                "width" => Arr::get($value , 'width', ""),
                "height" => Arr::get($value , 'height', ""),
                "weight" => Arr::get($value , 'weight', ""),
            ],
            [
                "length" => ['required','numeric', 'min:0'],
                "width" => ['required','numeric', 'min:0'],
                "height" => ['required','numeric', 'min:0'],
                "weight" => ['required','numeric', 'min:0'],
            ],
            [
                'length.required' => 'Поле :attribute при Mgx обязательно для заполнения.',
                'length.numeric' => 'Поле :attribute при Mgx должно быть числом.',
                'length.min' => 'Поле :attribute при Mgx должно быть не меньше 0.',

                'width.required' => 'Поле :attribute при Mgx обязательно для заполнения.',
                'width.numeric' => 'Поле :attribute при Mgx должно быть числом.',
                'width.min' => 'Поле :attribute при Mgx должно быть не меньше 0.',

                'height.required' => 'Поле :attribute при Mgx обязательно для заполнения.',
                'height.numeric' => 'Поле :attribute при Mgx должно быть числом.',
                'height.min' => 'Поле :attribute при Mgx должно быть не меньше 0.',

                'weight.required' => 'Поле :attribute при Mgx обязательно для заполнения.',
                'weight.numeric' => 'Поле :attribute при Mgx должно быть числом.',
                'weight.min' => 'Поле :attribute при Mgx должно быть не меньше 0.',
            ]
        );


        if ($validatorGood->fails()) {
            //Здесь будут использованы пользовательские сообщения

            $validatorGood->setAttributeNames([
                'length' => 'Длина',
                'width' => 'Ширина',
                'height' => 'Высота',
                'weight' => 'Вес',
                // можете указать имена для других полей, если необходимо
            ]);

            $errors = $validatorGood->errors()->all();

            $fail(implode(', ', $errors));
            return;
        }

    }

}
