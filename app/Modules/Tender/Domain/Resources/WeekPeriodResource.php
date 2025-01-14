<?php

namespace App\Modules\Tender\Domain\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeekPeriodResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            $this->value
        ];
    }

}
