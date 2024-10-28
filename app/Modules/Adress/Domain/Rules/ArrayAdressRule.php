<?php

namespace App\Modules\Adress\Domain\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use Illuminate\Support\Facades\Validator;

class ArrayAdressRule implements ValidationRule
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


        foreach($value as $subArray){

            // Проверяем, что значение в массиве является массивом
            if (!is_array($subArray)) {
                $fail("Ошибка :attribute должен быть массивом и содержать в себе массив адрессов, пример: [ [ uuid1 => date1 ], [ uuid2 => date2 ], [ uuid2 => date2 ] ]");
                return;
            }

            foreach ($subArray as $uuid => $date) {

                $validator = Validator::make(
                    ['uuid' => $uuid, 'date' => $date],
                    [
                        'uuid' => 'required|uuid',
                        'date' => 'required|date',
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

}
