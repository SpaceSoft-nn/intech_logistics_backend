<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\Base\Error\BusinessException;
use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSize;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSizeHelper;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

use function App\Helpers\Mylog;

/**
 * Сервес предназначен для проверки валидации указанных MGX и указанного типа паллета в грузе.
 */
class MgxValidationService
{
    private PalletSize $sizePallet;

    public function __construct(
        public CargoGood $cargoGood,
    ) {

        if(is_null($cargoGood->mgx)) {
            Mylog('Ошибка в MgxValidationService - кастомные данные (MGX) у груза не указаны, сделайте валидацию на сервесе выше!');
            throw new NotFoundHttpException('Данных MGX - для данного груза не указаны.', null , 500);
        }

        { //инициализируем PalletSize - что бы с ним работать
            /**
            * @var TypeSizePalletSpaceEnum
            */
            $type_pallet = $this->cargoGood->type_pallet;

            /**
            * @var PalletSize
            */
            $this->sizePallet = PalletSizeHelper::getSize($type_pallet);
        }

    }

     /**
     * Подсчитывает общий объём груза и Общий Объём паллета, и присылаем true, если объём удовлетворяет, объёму паллета
     * @return bool
     */
    public function isTrueCalculateBodyVolumeGeneral() : bool
    {

        if(is_null($this->cargoGood->mgx)) {
            Mylog('Ошибка в CargoGoodService в методе isTrueCalculateBodyVolumeGeneral');
            throw new Exception('У Груза нету кастомных указанных Характеристик', 500);
        }

        return $this->sizePallet->satisfoSizeModel($this->cargoGood->mgx);
    }

    /**
     * Проверяем что Указанные MGX, подходят под размеры паллета по длине
     * @param CargoGood $this->cargoGood
     * @return bool
     */
    public function checkSizeIsTrueLength() : bool
    {

        /**
        * @var
        */
        $mgx = $this->cargoGood->mgx;


        if($this->sizePallet->сompareLengthOfMgx($mgx))
        {

            return true;

        } else {

            return $this->messageError('length');

        }

    }

    /**
     * Проверяем что Указанные MGX, подходят под размеры паллета по ширине
     * @param CargoGood $this->cargoGood
     * @return bool
     */
    public function checkSizeIsTrueWidth() : bool
    {
        /**
        * @var
        */
        $mgx = $this->cargoGood->mgx;

        if($this->sizePallet->сompareWidthOfMgx($mgx))
        {

            return true;

        } else {

            return $this->messageError('width');

        }
    }

    #TODO - Под данный тип паллета с такой высотой может не подходить, выбрать надо кастом - делать ли эту логику
    /**
    * Проверяем что Указанные MGX, подходят под размеры паллета по Высоте т.е не больше 1.8 метров к примеру
    * @param CargoGood $this->cargoGood
    * @return bool
    */
    public function checkSizeIsTrueHeight() : bool
    {
        /**
        * @var
        */
        $mgx = $this->cargoGood->mgx;

        if($this->sizePallet->сompareHeightOfMgx($mgx)) {

            return true;

        } else {

            $dataInfo = [
                'model' => 'mgx',
                'error' => "height",
                'message' => "Указанные Массогабаритные-Характеристики по `Height` у груза: '{$this->cargoGood->product_type}', не подходят под данный тип паллета, максимальная высота для данного типа паллета: {$this->sizePallet->height}, у вас указана: {$mgx->height} .",
            ];

            //выкидываем ошибку и описание
            throw new BusinessException($dataInfo, 422);

        }
    }

    /**
     * Проверяем что Указанные MGX, подходят под размеры паллета по МАКСИМАЛЬНОЙ высоте
     * @param CargoGood $this->cargoGood
     * @return bool
     */
    public function checkSizeIsTrueMaxHeight() : bool
    {
        /**
        * @var Mgx
        */
        $mgx = $this->cargoGood->mgx;

        if($this->sizePallet->сompareHeighMaxtOfMgx($mgx))
        {
            return true;
        } else {

            $dataInfo = [
                'model' => 'mgx',
                'error' => "height",
                'message' => "Указанные Массогабаритные-Характеристики по максимальной `Height` у груза: '{$this->cargoGood->product_type}', не подходят, максимальная высота: {$this->sizePallet->max_height}, у вас указана: {$mgx->height} .",
            ];

            //выкидываем ошибку и описание
            throw new BusinessException($dataInfo, 422);
        }
    }

    /**
     * Возвращаем количество слоев которые нужно для того что бы уместить весь груз в 1 паллете
     * @return int
     */
    public function returnCountSizePalletHeightLayer() : ?int
    {
        $status = $this->sizePallet->isTrueOnePalletToHeight($this->cargoGood);

        //возаращаем NULL - если в 1 паллете в зависимости от высоты груза, не возможно расположить груз по слоям.
        if(!$status) { return null; }

        
    }

    /**
     * Возвращаем количество паллетов которые нужны для погрузки данного груза
     * @return int
     */
    private function returnCountSizePallet(string $sizeName) : int
    {
        return $this->sizePallet->returnCountSizePallet($this->cargoGood, $sizeName);
    }

    /**
     * Возвращаем сообщение ошибки или true - что ошибки нет от указанных параметров.
     * @param string $sizeName
     * @param string $name_product
     *
     * @return array|bool
     */
    private function messageError(string $sizeName) : array|bool
    {
        //получаем тип/имя продукта
        $name_product = $this->cargoGood->product_type;

        //получаем количество паллетов которое непобходимо под заданный размер
        $count_pallet = $this->returnCountSizePallet($sizeName);

        if($count_pallet != $this->cargoGood->cargo_units_count) {

            $dataInfo = [
                'model' => 'mgx',
                'new_count_pallet' => "{$count_pallet}",
                'old_count_pallet' => "{$this->cargoGood->cargo_units_count}",
                'error' => "{$sizeName}",
                'message' => "Указанные Массогабаритные-Характеристики по {$sizeName} у груза: '{$name_product}', не подходят под указанный тип паллета и указанное количество паллетов, Что бы груз уместился, укажите количество паллетов: {$count_pallet}, вы указали: {$this->cargoGood->cargo_units_count}.",
            ];

            //выкидываем ошибку и описание
            throw new BusinessException($dataInfo, 422);
        }

        return true;

    }

}
