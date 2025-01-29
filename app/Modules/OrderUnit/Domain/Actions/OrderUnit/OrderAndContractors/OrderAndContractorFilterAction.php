<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Support\Collection;

//Находим 1 заказ и укащываем откликнулся ли перевозчикн на заказ через атрибут модели.
class OrderAndContractorFilterAction
{
    public static function execute(string $organization_id, string $order_uuid) : ?OrderUnit
    {
        return self::run($organization_id, $order_uuid);
    }

    private static function run(string $organization_id, string $order_uuid) : ?OrderUnit
    {
        //Возвращаем все заказы + отфильтрованные выбранным перевозчиком
        $invoices = OrganizationOrderUnitInvoice::where('organization_id', $organization_id)->get();

        $order = OrderUnit::with('organization', 'user', 'mgx', 'lot_tender', 'contractor')->find($order_uuid);

        $order = collect([$order]);

        $order = $order->map(function (OrderUnit $item) use ($invoices) {

            foreach ($invoices as $invoice) {

                // dd($item->cargo_goods);

                if($invoice->order_unit_id === $item->id)
                {
                    //устанавливаем временный атрибут для вывода при json rersource на фронт
                    $item->setAttribute('isResponseContractor', true);

                    return $item;
                }

            }

            //устанавливаем временный атрибут для вывода при json rersource на фронт
            $item->setAttribute('isResponseContractor', false);

            return $item;

        });

        //возвращать надо 1 объект
        $order = $order->first();


        return $order;
    }
}
