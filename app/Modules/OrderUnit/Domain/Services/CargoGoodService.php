<?php

namespace App\Modules\OrderUnit\Domain\Services;

use App\Modules\Base\Error\BusinessException;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\CargoGood\CargoGoodVO;
use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSize;
use App\Modules\OrderUnit\Common\Helpers\Pallets\PalletSizeHelper;
use App\Modules\OrderUnit\Domain\Actions\CargoGood\CreateCargoGoodAndMgxAction;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use Exception;
use Illuminate\Database\Eloquent\Collection;

use function App\Helpers\Mylog;

class CargoGoodService
{

    public function createCargoGood(CargoGoodVO $vo) : CargoGood
    {
        return CreateCargoGoodAndMgxAction::make($vo);
    }

}
