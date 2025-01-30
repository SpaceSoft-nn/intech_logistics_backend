<?php

namespace App\Modules\Tender\Domain\Actions\LotTender;

use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;

//Находим 1 тендер и указываем откликнулся ли перевозчикн на заказ через атрибут модели.
class TenderAndContractorFilterAction
{
    public static function execute(string $organization_id, string $tender_uuid) : ?OrderUnit
    {
        return self::run($organization_id, $tender_uuid);
    }

    private static function run(string $organization_id, string $tender_uuid) : ?OrderUnit
    {
        //Возвращаем все заказы + отфильтрованные выбранным перевозчиком
        $responses = LotTenderResponse::where('organization_contractor_id', $organization_id)->get();

        $tender = LotTender::with(
            "agreement_document_tender", "application_document_tender",
            "specifica_date_period",
            "order_unit",
            "week_period",
        )->find($tender_uuid);

        $tender = collect([$tender]);

        $order = $tender->map(function (LotTender $item) use ($responses) {

            foreach ($responses as $response) {

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

        //возвращать надо 1 объект
        $order = $order->first();

        return $order;
    }
}
