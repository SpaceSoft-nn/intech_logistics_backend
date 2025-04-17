<?php

namespace App\Modules\Matrix\Domain\Actions;

use Exception;
use function App\Helpers\Mylog;
use App\Modules\Base\Error\BusinessException;

use App\Modules\Matrix\Domain\Models\RegionEconomicFactor;

use Illuminate\Database\UniqueConstraintViolationException;
use App\Modules\Matrix\App\Data\ValueObject\RegionEconomicFactorVO;

class CreateRegionEconomicFactorAction
{

    /**
     * @param RegionEconomicFactorVO $vo
     *
     * @return RegionEconomicFactor
     */
    public static function make(RegionEconomicFactorVO $vo) : RegionEconomicFactor
    {
        return (new self())->run($vo);
    }

    private function run(RegionEconomicFactorVO $vo) : RegionEconomicFactor
    {

        try {

            $md = RegionEconomicFactor::create($vo->toArrayNotNull());

        } catch (UniqueConstraintViolationException){

            throw new BusinessException('Такая запись городов уже существует.', 409);

        } catch (\Throwable $th) {

            Mylog('Ошибка при создании RegionEconomicFactor в CreateRegionEconomicFactor: ' . $th);
            throw new Exception('Ошибка при создании RegionEconomicFactor в Action {CreateRegionEconomicFactor}', 500);

        }

        return $md;
    }
}
