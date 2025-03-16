<?php

namespace App\Modules\OfferContractor\Domain\Interactor;

use DB;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOrderDTO;

class AgreementOfferOrderInteractor
{

    private function __construct(
        private OrderUnitService $orderUnitService,
    ) { }


    public static function execute(OfferContractorAgreementOrderDTO $dto) : bool
    {

        return (new self(app(OrderUnitService::class)))->run($dto);
    }


    private function run(OfferContractorAgreementOrderDTO $dto) : bool
    {
        {
            //Обновляем DTO - устанавливаем нужны значение
            $dto = $this->mappingOrderUnitVO($dto);
        }

        /**
        * @var bool
        */
        $status = DB::transaction(function () use ($dto) {

            /**
            * @var OrderUnitCreateDTO
            */
            $orderUnitCreateDTO = $dto->orderUnitCreateDTO;

            /**
            * @var AgreementOrderContractorAccept
            */
            $agreementOrderContractorAccept = $dto->agreementOrderContractorAccept;

            /**
            * @var AgreementOrderContractor
            */
            $agreementOrderContractor = $agreementOrderContractorAccept->agreement_order_contractor;

            { #TODO Вырезали временно логику ЭДО

                //получаем созданный заказ и устанавливаем его в таблицу agreementOrderContractorAccept
                $order_unit = $this->orderUnitService->createOrderUnit(
                    OrderUnitCreateDTO::make(
                        orderUnitVO: $orderUnitCreateDTO->orderUnitVO,
                        orderUnitAddressDTO: $orderUnitCreateDTO->orderUnitAddressDTO,
                        cargoGoodVO: $orderUnitCreateDTO->cargoGoodVO,
                    ),
                );

            }

            //устанавливаем в таблицу где подрядчик выбрал исполнителя (организацию заказчика), order_unit с которым теперь будет работать
            $agreementOrderContractor->order_unit_id = $order_unit->id;

            return $agreementOrderContractor->save();


        });

        return $status;
    }

    /**
     * Нужно обновить OrderUnitVO, указав ContractorId + organizationId
     * @return OfferContractorAgreementOrderDTO
     */
    private function mappingOrderUnitVO(OfferContractorAgreementOrderDTO $dto) : OfferContractorAgreementOrderDTO
    {
        #TODO нужно ли принимать organizationId - из request - или я могу заполнить его сразу по связям
        /**
         * @var OrderUnitVO
         */
        $orderUnitVO = $dto->orderUnitCreateDTO->orderUnitVO;

        /**
         * @var AgreementOrderContractorAccept
         */
        $agreementOrderContractorAccept = $dto->agreementOrderContractorAccept;


        { // получаем перевозчика и устанавливаем его в OrderUnit

            //Получаем организацию - перевозчика - через связи
            $organization_contractor_id = $agreementOrderContractorAccept->agreement_order_contractor->offer_contractor->organization_id;

            //Получаем орагнизацию заказчика
            $organization_customer_id = $agreementOrderContractorAccept->agreement_order_contractor->offer_contractor_invoice_order_customer->organization_id;

            //собираем новый VO указываем organization_id и contractor_id
            $orderUnitVO_new = $orderUnitVO->setContractorId($organization_contractor_id)->setOrganizationId($organization_customer_id);

            //собираем новый OrderUnitCreateDTO
            $orderUnitCreateDTO_new = OrderUnitCreateDTO::make(
                orderUnitVO: $orderUnitVO_new,
                orderUnitAddressDTO: $dto->orderUnitCreateDTO->orderUnitAddressDTO ,
                cargoGoodVO: $dto->orderUnitCreateDTO->cargoGoodVO,
            );
        }

        //возвращаем новый DTO с обновлёнными данными
        return OfferContractorAgreementOrderDTO::make(
            orderUnitCreateDTO: $orderUnitCreateDTO_new,
            agreementOrderContractorAccept: $dto->agreementOrderContractorAccept,
        );

    }

}
