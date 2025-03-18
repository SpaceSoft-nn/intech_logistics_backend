<?php

namespace App\Modules\Tender\Domain\Actions\LotTender;

use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
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

        $status_enum = collect([
            StatusTenderEnum::published,
            StatusTenderEnum::in_work,
            StatusTenderEnum::accepted,
        ]);


        //Возвращаем все заказы + отфильтрованные выбранным перевозчиком
        $responses = LotTenderResponse::where('organization_contractor_id', $organization_id)->get();

        $tenders = LotTender::with(
                "agreement_document_tender", "application_document_tender",
                "specifical_date_period",
                "order_unit",
                "week_period",
        )
        ->whereIn('status_tender', $status_enum)
        ->get();


        $array = $tenders->map(function (LotTender $item) use ($responses) {

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

        })->filter(function (LotTender $item) {

            //проверяем что при статусе in_work, отклик на тендер принадлежит перевозчику
            if( ($item->status_tender === (StatusTenderEnum::in_work || StatusTenderEnum::accepted) ) &&
            ($item->getAttribute('isResponseContractor') === false) )
            {   return false;  }

            return true;

        });


        return $array;
    }
}
