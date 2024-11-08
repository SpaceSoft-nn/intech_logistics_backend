<?php

namespace App\Modules\Address\Domain\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use Illuminate\Support\Facades\Validator;

class ArrayCargoGoodRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {


    }

}
