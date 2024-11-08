<?php

namespace App\Modules\PalletSpace\Common\Helpers;

class PalletSize
{
    public float $length; // Длина
    public float $width;  // Ширина
    public ?float $height;  // Высота

    public function __construct(float $length, float $width, ?float $height = 1.8)
    {
        $this->length = $length;
        $this->width = $width;
        if(is_null($height)) { $this->height = 1.8; } else { $this->height = $height; }

    }

    public function volume(float $height = null): float
    {
        //если высота указана
        if(!is_null($height)) { return $this->length * $this->width * $height;  }

        // Рассчитываем объем (длина * ширина * высота)
        return $this->length * $this->width * $this->$height;
    }
}

