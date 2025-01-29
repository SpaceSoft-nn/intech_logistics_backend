<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Support\Collection;

//Мапим весь массив, всех заказов и фильтруем для перевозчика, когда он откликнулся на заказ
class OrdersAndContractorFilterAction
{
    public static function execute(string $organization_id) : Collection
    {
        return self::run($organization_id);
    }

    private static function run(string $organization_id) : Collection
    {
        //Возвращаем все заказы + отфильтрованные выбранным перевозчиком
        $invoices = OrganizationOrderUnitInvoice::where('organization_id', $organization_id)->get();

        $orders = OrderUnit::with('organization', 'user', 'mgx', 'lot_tender', 'contractor')->get();

        $array = $orders->map(function (OrderUnit $item) use ($invoices) {

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

        return $array;
    }
}
