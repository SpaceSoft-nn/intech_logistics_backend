<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\App\Data\ValueObject\Response\InvoiceLotTenderVO;
use App\Modules\Tender\App\Data\ValueObject\Response\LotTenderResponseVO;
use App\Modules\Tender\Domain\Actions\Response\CreateInvoiceLotTenderAction;
use App\Modules\Tender\Domain\Actions\Response\CreateLotTenderResponseAction;
use App\Modules\Tender\Domain\Models\Response\InvoiceLotTender;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;
use DB;

/**
 * Интерактор для создание LotTender - так же логика добавление файлов + адрессов к LotTender
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
        /** @var LotTenderResponse  */
        $model = DB::transaction(function () use ($dto) {

            /** @var LotTenderResponse */
            $lotTenderResponse = $this->createLotTenderResponseVO($dto);

            /** @var InvoiceLotTender  */
            $invoiceLotTender = $this->createInvoiceLotTender($dto, $lotTenderResponse->id);

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


}
