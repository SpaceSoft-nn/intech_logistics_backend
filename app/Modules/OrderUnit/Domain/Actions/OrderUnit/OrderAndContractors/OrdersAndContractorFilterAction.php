<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

//Мапим весь массив, всех заказов и фильтруем для перевозчика, когда он откликнулся на заказ
class OrdersAndContractorFilterAction
{
    public static function execute(string $organization_id, array $status) : Collection
    {
        return self::run($organization_id, $status);
    }

    private static function run(string $organization_id, array $status) : Collection
    {

        $status_enum = collect([
            StatusOrderUnitEnum::published,
            StatusOrderUnitEnum::in_work,
            StatusOrderUnitEnum::pre_order,
        ]);


        //Возвращаем все заказы + отфильтрованные выбранным перевозчиком
        $invoices = OrganizationOrderUnitInvoice::where('organization_id', $organization_id)->get();

        $orders = OrderUnit::with('organization', 'user', 'mgx', 'lot_tender', 'contractor')
            ->whereHas('actual_status', function (Builder $query) use ($status_enum) {

                //проверяем что статус не null и массив не пустой
                if(!is_null($status_enum) && !$status_enum->isEmpty()){
                    $query->whereIn('status', $status_enum);
                }

            })
            ->get();


        $array = $orders->map(function (OrderUnit $item) use ($invoices) {

            foreach ($invoices as $invoice) {

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
        })->filter(function (OrderUnit $item) {

            //проверяем что при статусе in_work, отклик на заказ принадлежит перевозчику
            if( ($item->actual_status->status === StatusOrderUnitEnum::in_work) &&
            ($item->getAttribute('isResponseContractor') === false) )
            {   return false;  }

            return true;

        });

        return $array;
    }
}
