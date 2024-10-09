<?php

namespace App\Modules\OrderUnit\Domain\Interface\Algorithm;

use App\Modules\OrderUnit\Domain\Models\OrderUnit;

interface IVectorMoventAlgorithm
{
    public function run(OrderUnit $mainVector, OrderUnit $otherVector) : bool;
}
