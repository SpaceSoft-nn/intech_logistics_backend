<?php

namespace App\Modules\OfferContractor\Domain\Actions\Filter;

use App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use Illuminate\Support\Collection;

//Мапим весь массив, всех предложений перевозчика и фильтруем для заказчика, когда заказчик откликнулся на заказ
class OfferContractorsAndCustomerFilter
{
    public static function execute(string $organization_id) : Collection
    {
        return self::run($organization_id);
    }

    private static function run(string $organization_id) : Collection
    {

        $status_enum = [
            OfferContractorStatusEnum::published,
            OfferContractorStatusEnum::in_work,
            // OfferContractorStatusEnum::draft,
        ];


        //Получаем все отклики от заказчика на предложения перевозчика
        $invoices = OfferContractorCustomer::where('organization_id', $organization_id)->get();

        $offers = OfferContractor::with('offer_contractor_customer', 'agreement_order_contractor')
            ->whereIn('status', $status_enum)
            ->get();


        $array = $offers->map(function (OfferContractor $item) use ($invoices) {

            foreach ($invoices as $invoice) {

                if($invoice->offer_contractor_id === $item->id)
                {
                    //устанавливаем временный атрибут для вывода при json rersource на фронт
                    $item->setAttribute('isResponseContractor', true);

                    return $item;
                }
            }

            //устанавливаем временный атрибут для вывода при json rersource на фронт
            $item->setAttribute('isResponseContractor', false);

            return $item;

        })->filter(function (OfferContractor $item) {

            //проверяем что при статусе in_work, отклик на заказ принадлежит перевозчику
            if( ($item->status === OfferContractorStatusEnum::in_work) &&
            ($item->getAttribute('isResponseContractor') === false) )
            {   return false;  }

            return true;

        });

        return $array;
    }
}
