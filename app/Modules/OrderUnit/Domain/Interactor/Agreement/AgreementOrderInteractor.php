<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Agreement;

use App\Modules\Base\Error\BusinessException;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Repositories\OrganizationOrderUnitInvoiceRepository;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitStatus\OrderUnitStatusVO;
use App\Modules\OrderUnit\App\Repositories\AgreementOrderRepository;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Actions\Agreement\AgreementOrderAcceptCreateAction;
use App\Modules\OrderUnit\Domain\Actions\Agreement\AgreementOrderCreateAction;
use App\Modules\OrderUnit\Domain\Actions\OrderUnit\OrderUnitSatus\OrderUnitStatusCreateAction;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\OrderUnitStatus;
use DB;
use Exception;

use function App\Helpers\Mylog;

/**
 * Интерактор для работы бизнес-логики когда заказчик выбирает подрядчика
 */
final class AgreementOrderInteractor
{

    protected OrganizationOrderUnitInvoice $organizationOrderUnitInvoiceModel;
    protected OrderUnit $orderUnit;




    public function __construct(
        private AgreementOrderRepository $agreementOrderRep,
        private OrderUnitRepository $orderUnitRep,
        private OrganizationOrderUnitInvoiceRepository $organizationOrderUnitInvoiceRep,
    ) { }



    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrder
     */
    public function execute(AgreementOrderCreateDTO $dto) : ?AgreementOrder
    {
        //устанавливаем orderUnit в свойство
        $this->orderUnit = $this->orderUnitRep->get($dto->order_unit_id);

        //инициализируем свойства переменной моделью
        $this->organizationOrderUnitInvoiceModel = $this->getOrganizationOrderUnitsInvoce($dto->organization_order_units_invoce_id);

        //Обновляекм DTO указываем в значения organization_contractor_id
        $dto = $dto->setOrgContractroId($this->organizationOrderUnitInvoiceModel->organization_id);

        return $this->run($dto);
    }

    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrder
     */
    public function run(AgreementOrderCreateDTO $dto) : ?AgreementOrder
    {

        if($this->checkStatusAgreementOrder($dto->order_unit_id)) {  throw new BusinessException('Заказчик уже выбрал подрядчика.', 422);  }

            /** @var ?AgreementOrder */
            $model = DB::transaction(function ($pdo)  use ($dto) {

                /** @var AgreementOrder */
                $agreementOrderCreate = $this->agreementOrderCreate($dto);

                /** @var AgreementOrderAccept */
                $model = $this->agreementOrderAcceptCreate($agreementOrderCreate->id);


                //Устанавливаем OrderUnit - выбранного подрядичка в contractor_id
                $this->addContractorOrder();

                //устанавливаем в статус, что принят (указан перевозчик для выполнения заказа)
                $this->setStatusOrder(OrderUnitStatusVO::make(
                    order_unit_id: $this->orderUnit->id,
                    status: "accepted",
                ));

                //Что бы получить bool значение из модели
                $agreementOrderCreate->refresh();



                return $agreementOrderCreate;

            });

        return $model;

    }

    private function agreementOrderAcceptCreate(string $agreement_order_id) : ?AgreementOrderAccept
    {
        return AgreementOrderAcceptCreateAction::make($agreement_order_id);
    }

    private function agreementOrderCreate(AgreementOrderCreateDTO $dto) : ?AgreementOrder
    {
        return AgreementOrderCreateAction::make($dto);
    }


    /**
     * #TODO Проверяется только на существование записи, т.к - если заказчик или подрядчик откажется от заказа (придётся удалять запись что не рекомендуется) - в будущем добавить статусы в бд
     * Проверяем выбарн ли уже какой-нибудь подрядчик для заказа
     * @param string $order_id
     *
     * @return bool
     */
    private function checkStatusAgreementOrder(string $order_id) : bool
    {
        return $this->agreementOrderRep->checkStatusAgreementOrder($order_id);
    }

    /**
     * Добавляем contractor_id к Order (Заказчик выбрал подрядчика)
     * @return bool
    */
    private function addContractorOrder() : bool
    {

        try {

            /**
             * Получаем модель из свойства класса которое установлено при иницилизации
            * @var OrganizationOrderUnitInvoice
            */
            $organizationOrderUnitInvoiceModel = $this->organizationOrderUnitInvoiceModel;

            /**
            * @var InvoiceOrder
            */
            $invoiceOrder = $organizationOrderUnitInvoiceModel->invoice_order;

            /**
            * @var OrderUnit
            */
            $order = $this->orderUnit;

            //устанавливаем организацию перевозчика
            $order->contractor_id = $organizationOrderUnitInvoiceModel->organization_id;

            //Устанавливаем транспорт организации
            $order->transport_id = $invoiceOrder->transport_id;

        } catch (\Throwable $th) {

            Mylog('Ошибка в AgreementOrderInteractor в методе: addContractorOrder' . $th);
            throw new Exception('Ошибка в AgreementOrderInteractor в методе: addContractorOrder', 500);

        }

        return $order->save() ? true : false;
    }

    private function getOrganizationOrderUnitsInvoce(string $organization_order_units_invoce_id) : OrganizationOrderUnitInvoice
    {
        return $this->organizationOrderUnitInvoiceRep->get($organization_order_units_invoce_id);
    }

   private function setStatusOrder(OrderUnitStatusVO $vo) : OrderUnitStatus
   {
        return OrderUnitStatusCreateAction::make($vo);
   }
}
