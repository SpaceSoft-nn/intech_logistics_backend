<?php

namespace App\Modules\OfferContractor\Domain\Interactor;

use DB;
use App\Modules\OrderUnit\Domain\Models\Mgx;
use App\Modules\Base\Error\BusinessException;
use App\Modules\OrderUnit\Domain\Models\CargoGood;
use App\Modules\OrderUnit\Domain\Services\MgxValidationService;
use App\Modules\OfferContractor\Domain\Models\InvoiceOrderCustomer;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use App\Modules\OfferContractor\App\Data\DTO\OfferCotractorAddCustomerDTO;
use App\Modules\OfferContractor\App\Data\ValueObject\InvoiceOrderCustomerVO;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorCustomerVO;
use App\Modules\OfferContractor\Domain\Actions\InvoiceOrderCustomerCreateAction;
use App\Modules\OfferContractor\Domain\Actions\OfferContractorInvoiceOrderCustomerCreateAction;

class ResponseOfferContractorInteractor
{

    public static function execute(OfferCotractorAddCustomerDTO $dto)
    {
        return (new self())->run($dto);
    }

    /**
     * @param OfferCotractorAddCustomerDTO $dto
     *
     * @return OfferContractorCustomer
     */
    private function run(OfferCotractorAddCustomerDTO $dto) : OfferContractorCustomer
    {
        /**
         * @var OfferContractorCustomer
         */
        $offerContractorCustomer = DB::transaction(function () use ($dto) {

            //валидируем значение mgx для cargoGood
            foreach ($dto->cargoGoodVO_array as $cargoGoodVO) {

                if($cargoGoodVO->mgx)
                {
                    //создамё объект модели без добавление в бд, для валидации.
                    $mgx = new Mgx($cargoGoodVO->mgx->toArrayNotNull());
                    $cargoGood = (new CargoGood($cargoGoodVO->toArrayNotNull()))->setRelation('mgx', $mgx);

                    //валидируем значения
                    (new MgxValidationService($cargoGood))->runVlidationMgx();

                }

            }

            /**
             * создаём абстрактный заказ от заказчика, для перевозчика.
             * @var InvoiceOrderCustomer
            */
            $invoiceOrderCustomer = $this->createInvoiceOrderCustomer($dto->invoiceOrderCustomerVO);

            /**
             * Создаём отклик на предложения перевозчика от Заказчика
             * @var OfferContractorCustomer
            */
            $offerContractorCustomer = $this->createOfferContractorInvoiceOrderCustomer($dto, $invoiceOrderCustomer);

            return $offerContractorCustomer;

        });

        return $offerContractorCustomer;
    }

    /**
     * Создаём запись в таблице InvoiceOrderCustomer
     * @param InvoiceOrderCustomerVO $vo
     *
     * @return InvoiceOrderCustomer
     */
    private function    createInvoiceOrderCustomer(InvoiceOrderCustomerVO $vo) : InvoiceOrderCustomer
    {
        return InvoiceOrderCustomerCreateAction::make($vo);
    }

    /**
     * Создаём запись в таблице связанную с OfferContractorCustomerVO
     * @param OfferCotractorAddCustomerDTO $dto
     * @param InvoiceOrderCustomer $invoiceOrderCustomer
     *
     * @return OfferContractorCustomer
     */
    private function createOfferContractorInvoiceOrderCustomer(OfferCotractorAddCustomerDTO $dto, InvoiceOrderCustomer $invoiceOrderCustomer) : OfferContractorCustomer
    {
        #TODO Когда будет работа с ролями, предусмотреть что данная организация уже отзывалась на отклик
        $status = OfferContractorCustomer::where('offer_contractor_id', $dto->offerContractor->id)->where('organization_id', $dto->organization->id)->first();

        //Если $orgId - уже откликнулась на заказ $orderId, выкидываем ошибку.
        if($status) { throw new BusinessException('Данная организация уже откликнулась на это предложения.', 422); }

        $model = OfferContractorInvoiceOrderCustomerCreateAction::make(
            OfferContractorCustomerVO::make(
                invoice_order_customer_id: $invoiceOrderCustomer->id,
                offer_contractor_id: $dto->offerContractor->id,
                organization_id: $dto->organization->id,
                user_id: null, #TODO Переделывать на таблицу где указано org + user
            ),
        );

        return $model;
    }
}
