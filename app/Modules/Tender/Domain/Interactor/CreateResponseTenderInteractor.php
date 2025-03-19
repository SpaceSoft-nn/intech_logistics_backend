<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\Base\Error\BusinessException;
use DB;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\Domain\Models\Response\InvoiceLotTender;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;
use App\Modules\Tender\App\Data\ValueObject\Response\InvoiceLotTenderVO;
use App\Modules\Tender\App\Data\ValueObject\Response\LotTenderResponseVO;
use App\Modules\Tender\Domain\Actions\Response\CreateInvoiceLotTenderAction;
use App\Modules\Tender\Domain\Actions\Response\CreateLotTenderResponseAction;

/**
 * Интерактор для создание Отклика на тендер
 */
final class CreateResponseTenderInteractor
{

    public function __construct(

    ) { }


    public function execute(CreateResponseTenderDTO $dto) : LotTenderResponse
    {
        return $this->run($dto);
    }


    public function run(CreateResponseTenderDTO $dto) : LotTenderResponse
    {

        //Проверяем откликнулась ли данная организация, если да выкидываем бизнес ошибку
        $this->exestResponse($dto->lot_tender_id, $dto->organizaion_id);


        /** @var LotTenderResponse  */
        $model = DB::transaction(function () use ($dto) {

            /** @var LotTenderResponse */
            $lotTenderResponse = $this->createLotTenderResponseVO($dto);

            /** @var InvoiceLotTender  */
            $invoiceLotTender = $this->createInvoiceLotTender($dto, $lotTenderResponse->id);

            #TODO Может быть баг с first
            $lotTenderResponse = $lotTenderResponse->with('invoice_lot_tender', 'organization_contractor', 'tender')->first();


            return $lotTenderResponse;

        });

        return $model;

    }

    private function createLotTenderResponseVO(CreateResponseTenderDTO $dto) : LotTenderResponse
    {
        return CreateLotTenderResponseAction::make(
            LotTenderResponseVO::make(
                lot_tender_id: $dto->lot_tender_id,
                organization_contractor_id: $dto->organizaion_id,
            )
        );
    }

    private function createInvoiceLotTender(CreateResponseTenderDTO $dto, string $lot_tender_response_id) : InvoiceLotTender
    {
        return CreateInvoiceLotTenderAction::make(
            InvoiceLotTenderVO::make(
                transport_id: $dto->transport_id,
                lot_tender_response_id: $lot_tender_response_id,
                price_for_km: $dto->price_for_km,
                comment: $dto->comment,
            )
        );
    }

    /**
     * Проверяем откликалась ли данная организация, если да выкидываешь бизнес ошибку
     * @param string $lotTenderId
     * @param string $organizaionContractorId
     *
     * @return void
     */
    private function exestResponse(string $lotTenderId, string $organizaionContractorId) : bool|BusinessException
    {

        $lotTender = LotTender::find($lotTenderId);

        /** @var LotTenderResponse */
        $lot_tender_response = $lotTender->lot_tender_response->where('organization_contractor_id', $organizaionContractorId)->first();

        if(!is_null($lot_tender_response)) { throw new BusinessException('Данная организация уже откликнулась на этот тендер.'); }

        return false;
    }

}
