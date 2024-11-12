<?php

namespace App\Modules\OrderUnit\Common\Helpers\Pallets;

use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use Exception;

use function App\Helpers\Mylog;

class PalletSize
{
    public float $length; // Длина
    public float $width;  // Ширина
    public float $height;  // Высота
    public float $max_height;

    public function __construct(float $length, float $width, float $height)
    {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->max_height = 3.8;
    }

    /**
    * Проверяем что модель по length, убираетя по длине в паллет
    * @param Mgx $model
    * @return bool
    */
    public function сompareLengthOfMgx(Mgx $model) : bool
    {
        return $model->length < $this->length;
    }

    /**
    * Проверяем что модель по width, убираетя по ширине в паллет
    * @param Mgx $model
    * @return bool
    */
    public function сompareWidthOfMgx(Mgx $model) : bool
    {
        return $model->width < $this->width;
    }

    /**
    * Проверяем что модель по height, убираетя по высоте в паллет
    * @param Mgx $model
    * @return bool
    */
    public function сompareHeightOfMgx(Mgx $model) : bool
    {
        return $model->height < $this->height;
    }

    /**
    * Проверяем что модель по height, убирается по МАКСИМАЛЬНОЙ высоте
    * @param Mgx $model
    * @return bool
    */
    public function сompareHeighMaxtOfMgx(Mgx $model) : bool
    {
        return $model->height < $this->max_height;
    }

    /**
    * Возвращаем количество паллетов которые нужны для погрузки данного груза
    * @return int
    */
    public function returnCountSizePallet(CargoGood $cargoGood, string $sizeName) : int
    {

        switch ($sizeName) {

            case 'length':
            {

                return $this->calculateCountPallet($cargoGood, $sizeName);

                break;
            }

            case 'width':
            {
                return $this->calculateCountPallet($cargoGood, $sizeName);

                break;
            }

            case 'height':
            {
                dd('Нужно ли это здесь?');
                break;
            }

            default:
            {

                Mylog('Ошибка кейса в switch в методе returnCountSizePallet, классе PalletSize');
                throw new Exception('Ошибка типа в switch', 500);

                break;
            }
        }
    }

    private function calculateCountPallet(CargoGood $cargoGood, string $sizeName) : int
    {

        /**
        * @var Mgx
        */
        $mgx = $cargoGood->mgx;

        /**
        * @var int
        */
        $cargo_units_count = $cargoGood->cargo_units_count;

        $flag = true;

        try {

            while ($flag) {

                $generalSize = $cargo_units_count * $this->$sizeName;

                if($generalSize > $mgx->$sizeName) {
                    $flag = false;
                    return $cargo_units_count;
                }

                $cargo_units_count++;
            }

        } catch (\Throwable $th) {

            Mylog('Ошибка в PalletSize в методе calculateCountPallet, возможно бесконечный цикл! ' . $th);
            throw new Exception('Ошибка в PalletSize в методе calculateCountPallet', 500);
        }


    }

    /**
     * Проверяем убирается ли по объёму указаный груз в 1 паллет (по объёмеу)
     * @param Mgx $model
     *
     * @return bool
     */
    public function satisfoSizeModel(Mgx $model) : bool
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

