<?php

namespace App\Modules\OfferContractor\Domain\Actions\Filter;

use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;

//Находим 1 заказ и укащываем откликнулся ли перевозчикн на заказ через атрибут модели.
class OfferContractorAndCustomerFilter
{
    public static function execute(string $organization_id, string $offer_contractor_uuid) : ?OfferContractor
    {
        return self::run($organization_id, $offer_contractor_uuid);
    }

    private static function run(string $organization_id, string $offer_contractor_uuid) : ?OfferContractor
    {
        //Получаем все отклики от заказчика на предложения перевозчика
        $invoices = OfferContractorCustomer::where('organization_id', $organization_id)->get();

        $offerContractor = OfferContractor::with('offer_contractor_customer', 'agreement_order_contractor')->find($offer_contractor_uuid);

        $offerContractor = collect([$offerContractor]);

        $offerContractor = $offerContractor->map(function (OfferContractor $item) use ($invoices) {

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

        });

        //возвращать надо 1 объект
        $order = $offerContractor->first();

        return $order;
    }
}
