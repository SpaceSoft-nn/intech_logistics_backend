<?php

namespace App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderAndContractors;

use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;
use Illuminate\Support\Collection;

//Мапим весь массив, всех заказов и фильтруем для перевозчика, когда он откликнулся на заказ
class TendersAndContractorFilterAction
{
    public static function execute(string $organization_id) : Collection
    {
        return self::run($organization_id);
    }

    private static function run(string $organization_id) : Collection
    {
        //Возвращаем все заказы + отфильтрованные выбранным перевозчиком
        $responses = LotTenderResponse::where('organization_contractor_id', $organization_id)->get();

        $tenders = LotTender::with(
            "agreement_document_tender", "application_document_tender",
            "specifica_date_period",
            "order_unit",
            "week_period",
        )->get();

        $array = $tenders->map(function (OrderUnit $item) use ($responses) {

            foreach ($responses as $response) {

                // dd($item->cargo_goods);

                if($response->lot_tender_id === $item->id)
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
