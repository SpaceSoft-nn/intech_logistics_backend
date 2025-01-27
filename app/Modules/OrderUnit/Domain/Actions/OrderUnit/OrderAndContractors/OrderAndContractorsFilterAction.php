<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Support\Collection;

//Мапим весь массив, всех заказов и фильтруем для перевозчика, когда он откликнулся на заказ
class OrderAndContractorsFilterAction
{
    public static function make(string $organization_id) : Collection
    {
        return self::run($organization_id);
    }

    private static function run(string $organization_id) : Collection
    {
        //Возвращаем все заказы + отфильтровано выбранные перевозчиком
        $invoices = OrganizationOrderUnitInvoice::where('organization_id', $organization_id)->get();

        $orders = OrderUnit::with('organization', 'user', 'lot_tender')->get();

        $array = $orders->map(function (OrderUnit $item) use ($invoices) {

            foreach ($invoices as $invoice) {

                if($invoice->order_unit_id === $item->id)
                {
                    $actual_status = $item->actual_status->status->value;

                    $array = array_merge($item->toArray(), ['isResponseContractor' => true]);

                    $array = array_merge($array, ['actual_status' => $actual_status]);

                    // dd($array);

                    return  $array;
                }

            }

            $actual_status = $item->actual_status->status->value;

            $array = array_merge($item->toArray(), ['isResponseContractor' => true]);

            $array = array_merge($array, ['actual_status' => $actual_status]);

            return $array;

        });

        return $array;
    }
}
