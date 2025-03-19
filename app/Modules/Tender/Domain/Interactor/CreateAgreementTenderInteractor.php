<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\Base\Error\BusinessException;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderAcceptVO;
use App\Modules\Tender\App\Data\ValueObject\Response\AgreementTenderVO;

use App\Modules\Tender\Domain\Actions\Response\CreateAgreementTenderAcceptAction;
use App\Modules\Tender\Domain\Actions\Response\CreateAgreementTenderAction;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;

use DB;

/**
 * Интерактор содержащий бизнес логику для: *Создатель тендера выбирает подрядчика на выполнения тендера
 */
final class CreateAgreementTenderInteractor
{

    public function execute(AgreementTenderVO $vo) : AgreementTender
    {
        return $this->run($vo);
    }


    public function run(AgreementTenderVO $vo) : AgreementTender
    {
        //проверяем был ли уже выбран перевозчик
        $this->exestResponse($vo);

        /** @var AgreementTender  */
        $model = DB::transaction(function () use ($vo) {


            /** @var AgreementTender */
            $agreementTender = $this->createAgreementTender($vo);

            /** @var AgreementTenderAccept */
            $agreementTenderAccept = $this->createAgreementTenderAccept(
                AgreementTenderAcceptVO::make(
                    agreement_tender_id: $agreementTender->id,
                    tender_creater_bool : null,
                    contractor_bool: null,
                )
            );

            { //устанавливаем статус для тендера в работе

                /** @var LotTender */
                $LotTender = $this->findLotTender($vo->lot_tender_id);

                $LotTender->status_tender = StatusTenderEnum::accepted;

                $LotTender->save();

            }

            return $agreementTender;

        });

        return $model;

    }

    private function createAgreementTender(AgreementTenderVO $vo) : AgreementTender
    {
        return CreateAgreementTenderAction::make($vo);
    }

    private function createAgreementTenderAccept(AgreementTenderAcceptVO $vo) : AgreementTenderAccept
    {
        return CreateAgreementTenderAcceptAction::make($vo);
    }

    private function findLotTender(string $id) : LotTender
    {
        /** @var LotTender */
        $LotTender = LotTender::find($id);

        if(!$LotTender){
           throw new BusinessException('Lot Tender не найден.' ,404);
        }

        return $LotTender;
    }

    #TODO Если будет функционал изменение выбранного отклика или удаление, нужно менять проверку
    //Проверяем выбрал ли заказчик уже перевозчика
    private function exestResponse(AgreementTenderVO $vo)
    {
        $model = AgreementTender::where('lot_tender_response_id', $vo->lot_tender_response_id)
            ->where('organization_contractor_id', $vo->organization_contractor_id)
            ->where('lot_tender_id', $vo->lot_tender_id)
            ->first();

        if(!is_null($model)) { return throw new BusinessException('Заказчик уже выбрал перевозчика, на исполнения этого Тендера'); }
    }

}
