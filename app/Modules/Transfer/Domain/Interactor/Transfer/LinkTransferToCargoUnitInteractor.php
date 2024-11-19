<?php

namespace App\Modules\Transfer\Domain\Interactor\Transfer;

use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\CargoUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Transfer\Domain\Actions\LinkManyToMany\LinkTransferToCargoUnitAction;
use App\Modules\Transfer\Domain\Models\Transfer;
use DB;
use Exception;

use function App\Helpers\Mylog;

/**
 * Объединение создание логики transfer с остальными таблицами/моделями
 */
class LinkTransferToCargoUnitInteractor
{


    public function __construct(
        private OrderUnitRepository $orderUnitRepository,

    ) { }

    /**
     * @param Transfer $transfer
     * @param OrderUnit $order
     *
     * @return bool
     */
    public function execute(Transfer $transfer, OrderUnit $order) : bool
    {
        return $this->run($transfer, $order);
    }


    /**
     * @param Transfer $transfer
     * @param OrderUnit $order
     *
     * @return bool
     */
    private function run(Transfer $transfer, OrderUnit $order) : bool
    {

        try {

            return DB::transaction(function ($pdo) use ($transfer, $order) {

                /**
                * @var CargoUnit
                */
                $cargo_units = $this->orderUnitRepository->cargo_units($order);

                if(is_null($cargo_units)) {

                    Mylog('Ошибка в интеракторе LinkTransferToCargoUnitInteractor: cargo_unit = null, такого не должно быть.');
                    throw new Exception('Ошибка в интеракторе LinkTransferToCargoUnitInteractor', 500);

                }

                foreach ($cargo_units as $cargo_unit) {

                    LinkTransferToCargoUnitAction::run($transfer, $cargo_unit);

                }

                return true;

            });

        } catch (\Throwable $th) {

            Mylog('Ошибка в интеракторе LinkTransferToCargoUnitInteractor: ' . $th);
            throw new Exception('Ошибка в интеракторе LinkTransferToCargoUnitInteractor', 500);

        }

    }

}
