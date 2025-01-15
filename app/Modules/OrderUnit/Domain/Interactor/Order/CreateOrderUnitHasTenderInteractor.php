<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Order;

use DB;
use Exception;
use function App\Helpers\Mylog;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;

use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitCreateAction;

// Бизнес логика для создание заказа, когда заказ создатёся от Тендера
class CreateOrderUnitHasTenderInteractor
{

    public function __construct(

    ) { }

    /**
     * @param OrderUnitVO $vo
     *
     * @return OrderUnit
     */
    public function execute(OrderUnitVO $vo) : OrderUnit
    {
        return $this->run($vo);
    }

    /**
     * @param OrderUnitVO $vo
     *
     * @return OrderUnit
     */
    private function run(OrderUnitVO $vo) : OrderUnit
    {

        try {

            /** @var OrderUnit */
            $order = DB::transaction(function($pdo) use($vo)  {

                #TODO Нужно использовать паттерн цепочка обязаностей (handler)
                /** @var OrderUnit */
                return $this->createOrderUnit($vo);

            });

        } catch (\Throwable $th) {

            $nameClass = self::class;

            Mylog("Ошибка в {$nameClass} при создании записи: " . $th);
            throw new Exception('Ошибка в классе: ' . $nameClass, 500);
        }


        return $order;
    }

    private function createOrderUnit(OrderUnitVO $vo) : ?OrderUnit
    {

        if(is_null($vo->order_status)) {
            //Если статус заказа не указан, устанавливаем что он в статусе: предзаказ
            $vo = $vo->setOrderStatus(StatusOrderUnitEnum::pre_order);
        }

        return OrderUnitCreateAction::make($vo);
    }

}
