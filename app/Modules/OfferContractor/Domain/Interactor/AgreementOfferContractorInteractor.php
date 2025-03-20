<?php

namespace App\Modules\OfferContractor\Domain\Interactor;

use DB;
use App\Modules\Base\Error\BusinessException;
use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OfferContractor\App\Data\Enums\OfferContractorStatusEnum;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOfferDTO;
use App\Modules\OfferContractor\App\Data\ValueObject\AgreementOrderContractorVO;
use App\Modules\OfferContractor\Domain\Actions\CreateAgreementOrderContractorAction;

use App\Modules\OfferContractor\Domain\Actions\CreateAgreementOrderContractorAcceptAction;

class AgreementOfferContractorInteractor
{

    public static function execute(OfferContractorAgreementOfferDTO $dto) : AgreementOrderContractor
    {
        return (new self())->run($dto);
    }


    private function run(OfferContractorAgreementOfferDTO $dto) : AgreementOrderContractor
    {

        //валидимируем данные (выкидываем бизнес ошибки)
        $this->checkValidation($dto);

        /**
        * @var AgreementOrderContractor
        */
        $agreementOrderContractor = DB::transaction(function () use ($dto) {

            /**
            * @var AgreementOrderContractor
            */
            $agreementOrderContractor = $this->createAgreementOrderContractor($dto);

            /**
            * @var AgreementOrderContractorAccept
            */
            $agreementOrderContractorAccept = $this->createAgreementOrderContractorAccept($agreementOrderContractor->id);


            { // устанавливаем статус принят

                /** @var OfferContractor */
                $offerContractor = $dto->offerContractor;

                $offerContractor->status = OfferContractorStatusEnum::accepted;

                $offerContractor->save();

            }

            return $agreementOrderContractor;

        });



        return $agreementOrderContractor;
    }

    private function createAgreementOrderContractor(OfferContractorAgreementOfferDTO $dto) : AgreementOrderContractor
    {


        //Создаём запись - когда перевозчик выбрал (орагинзацию заказчика) на предложения, пока согласование с двух сторон нету, то order_unit_id = null (заказ создавать после согласования)
        return CreateAgreementOrderContractorAction::make(
            AgreementOrderContractorVO::make(
                offer_contractor_invoice_order_customer_id: $dto->offer_contractor_customer_id,
                offer_contractor_id: $dto->offerContractor->id,
                order_unit_id: null,
                organization_contractor_id: $dto->offerContractor->organization_id,
                user_id: null,
            )
        );
    }

    private function createAgreementOrderContractorAccept(string $agreement_order_contractor_id) : AgreementOrderContractorAccept
    {
        return CreateAgreementOrderContractorAcceptAction::make($agreement_order_contractor_id);
    }

    private function checkValidation(OfferContractorAgreementOfferDTO $dto)
    {
        { // проверка на повторный отклик
            $status = AgreementOrderContractor::where('offer_contractor_invoice_order_customer_id', $dto->offer_contractor_customer_id)->first();

            if(!is_null($status))
            {
                throw new BusinessException('Организация заказчика, уже была выбрана на это предложения.', 422);
            }
        }

        { //проверка если на предложения уже откликнулись ранее
            /**
            * @var OfferContractor
            */
            $offerContractor = $dto->offerContractor;

            if(!is_null($offerContractor->agreement_order_contractor))
            {
                throw new BusinessException('Перевозчик для этого предложения, уже выбрал организацию - заказчика.', 422);
            }
        }
    }

}
