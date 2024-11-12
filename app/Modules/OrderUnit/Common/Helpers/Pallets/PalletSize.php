<?php

namespace App\Modules\OrderUnit\Common\Helpers\Pallets;

use App\Modules\OrderUnit\Domain\Models\Mgx;

class PalletSize
{
    public float $length; // Длина
    public float $width;  // Ширина
    public float $height;  // Высота

    public function __construct(float $length, float $width, float $height)
    {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Проверяем убирается ли по объёму указаный груз в 1 паллет (по объёмеу)
     * @param Mgx $model
     *
     * @return bool
     */
    public function SatisfoSizeModel(Mgx $model) : bool
    {
        $modelSize = $this->getSizeModel($model);
        $palletSize = $this->volume();

        return $modelSize <= $palletSize;
    }

    /**
     * Вернуть объём Model mgx
     * @param Mgx $model
     *
     * @return float
     */
    public function getSizeModel(Mgx $model) : float
    {
        $modelSize = $model->length * $model->width * $model->height;

        return $modelSize;
    }



    public function volume(float $height = null): float
    {

        //если высота указана
        if(!is_null($height)) { return $this->length * $this->width * $height;  }

        // Рассчитываем объем (длина * ширина * высота)
        return $this->length * $this->width * $this->height;
    }
}

