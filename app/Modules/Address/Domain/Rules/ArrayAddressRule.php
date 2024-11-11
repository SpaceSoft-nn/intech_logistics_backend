<?php

namespace App\Modules\Address\Domain\Rules;

use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArrayAddressRule implements ValidationRule
{

    public function validate(string $attribute, mixed $values, Closure $fail): void
    {

        // Проверяем, что значение является массивом
        if (!is_array($values)) {
            $fail('Ошибка :attribute должен быть массивом.');
            return;
        }

        $messagesBagError = [
            'key.uuid' => 'Указанный :attribute ключ не является корректным UUID.',
            'key.date' => 'Указанное :attribute значение ключа не является верным форматом DATE',
        ];

        $typeStateAddressArray = array_column(TypeStateAddressEnum::cases(), 'name');


        foreach($values as $value){

            // Проверяем, что значение в массиве является массивом
            if (!is_array($value)) {
                $fail("Ошибка :attribute должен быть массивом и содержать в себе массив адрессов, пример: [ [ id => 'uuid', date => '01.01.2025', type => 'enum_value' ], [ id => 'uuid', date => '01.01.2025', type => 'enum_value' ] ]");
                return;
            }


            $validator = Validator::make(
                ['id' => $value['id'] ?? null, 'date' => $value['date'] ?? null, 'type' => $value['type'] ?? null],
                [
                    'id' => ['required', 'uuid'],
                    'date' => ['required', 'date'],
                    'type' => ['required', Rule::in($typeStateAddressArray)],
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
