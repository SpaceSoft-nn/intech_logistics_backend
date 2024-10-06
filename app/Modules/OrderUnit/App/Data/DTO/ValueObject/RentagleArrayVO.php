<?php

namespace App\Modules\OrderUnit\App\Data\DTO\ValueObject;

/**
 * [Description RentagleArrayVO]
 */
class RentagleArrayVO
{
    public function __construct(
        public string|float $startLat,
        public string|float $startLng,
        public string|float $endLat,
        public string|float $endLng,
    ) { }

    public static function make(
        string|float $startLat,
        string|float $startLng,
        string|float $endLat,
        string|float $endLng,
    ) {
        return new self(
            startLat: $startLat,
            startLng: $startLng,
            endLat: $endLat,
            endLng: $endLng,
        );
    }

}
