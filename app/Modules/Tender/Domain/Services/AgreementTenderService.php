<?php

namespace App\Modules\Tender\Domain\Services;

use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\Tender\App\Data\DTO\CreateResponseTenderDTO;
use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;
use App\Modules\Tender\Domain\Interactor\AgreementTenderAcceptInteractor;
use App\Modules\Tender\Domain\Interactor\CreateAgreementTenderInteractor;
use App\Modules\Tender\Domain\Interactor\CreateResponseTenderInteractor;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use App\Modules\Tender\Domain\Models\Response\LotTenderResponse;
use Illuminate\Support\Carbon;

final class AgreementTenderService
{
    public function __construct(
        private CreateResponseTenderInteractor $createResponseTenderInteractor,
        private CreateAgreementTenderInteractor $сreateAgreementTenderInteractor,
        private AgreementTenderAcceptInteractor $agreementTenderAcceptInteractor,
    ) { }

    /**
     * Перевозчик откликается на тендер, создание записи:
     * InvoiceLotTender  и LotTenderResponse
     * @param CreateResponseTenderDTO $dto
     *
     * @return LotTenderResponse
     */
    public function respondToTender(CreateResponseTenderDTO $dto) : LotTenderResponse
    {
        return $this->createResponseTenderInteractor->execute($dto);
    }

    /**
     * Создатель тендера выбирает подрядчика на выполнения тендера
     * @param AgreementTenderVO $AgreementTenderVO
     *
     * @return AgreementTender
     */
    public function agreementTender(AgreementTenderVO $AgreementTenderVO) : AgreementTender
    {
        return $this->сreateAgreementTenderInteractor->execute($AgreementTenderVO);
    }

    /**
     * Подтврждения соглашения между сторонами, на принятие тендера в работу
     * #TODO - тут создавать заказы, после подтврждения и предусмотреть нормальную логику работы при ролях
     * @param AgreementTenderAccept $agreementTenderAccept
     *
     * @return AgreementTenderAccept
     */
    public function agreementTenderAccept(AgreementTenderAccept $agreementTenderAccept) : AgreementTenderAccept
    {
        return $this->agreementTenderAcceptInteractor->execute($agreementTenderAccept);
    }

    public function mappingOrderUnitVO(AgreementTenderAccept $agreementTenderAccept) : OrderUnitVO
    {
        /** @var AgreementTender */
        $agreement_tender = $agreementTenderAccept->agreement_tender;

        /** @var LotTender */
        $lot_tender = $agreement_tender->lot_tender;

        {
            $carbon_date_start = Carbon::createFromFormat('d,m,Y', $lot_tender->date_start);

            //получем конечную дату в зависимости от периода
            $carbon_date_end = $carbon_date_start->addDays($lot_tender->period);
        }


        $orderUnitVO = OrderUnitVO::make(
            end_date_order: $carbon_date_end->toDateString(),
            body_volume: $lot_tender->body_volume_for_order,
            order_total: $lot_tender->price_for_km,
            type_transport_weight: $lot_tender->type_transport_weight->value,
            type_load_truck: $lot_tender->type_load_truck->value,
            organization_id: $lot_tender->organization_id,
            user_id: null, #TODO Продумать логику при ролях, как указывать правильно
            contractor_id: $agreement_tender->organization_contractor_id, //указываем подрядчика на выполнения заказа
            lot_tender_id: $lot_tender->id,
            add_load_space: false, #TODO Продумать что тут указывать?
        );

        return $orderUnitVO;
    }
}

