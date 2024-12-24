<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Agreement;

use App\Modules\Base\Error\BusinessException;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Repositories\OrganizationOrderUnitInvoiceRepository;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\App\Repositories\AgreementOrderRepository;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Actions\Agreement\AgreementOrderAcceptCreateAction;
use App\Modules\OrderUnit\Domain\Actions\Agreement\AgreementOrderCreateAction;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use DB;
use Exception;

use function App\Helpers\Mylog;

/**
 * Интерактор для работы бизнес-логики когда заказчик выбирает подрядчика
 */
final class AgreementOrderInteractor
{

    public function __construct(
        private AgreementOrderRepository $agreementOrderRep,
        private OrderUnitRepository $orderUnitRep,
        private OrganizationOrderUnitInvoiceRepository $organizationOrderUnitInvoiceRep,
    ) { }


    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrderAccept
     */
    public function execute(AgreementOrderCreateDTO $dto) : ?AgreementOrderAccept
    {
        return $this->run($dto);
    }

    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrderAccept
     */
    public function run(AgreementOrderCreateDTO $dto) : ?AgreementOrderAccept
    {

        if($this->checkStatusAgreementOrder($dto->order_unit_id)) {  throw new BusinessException('Заказчик уже выбрал подрядчика.', 422);  }

        $model = DB::transaction(function ($pdo)  use ($dto) {

            $agreementOrderCreate = $this->agreementOrderCreate($dto);

            $model = $this->agreementOrderAcceptCreate($agreementOrderCreate->id);

            //Устанавливаем OrderUnit - выбранного подрядичка в contractor_id
            $this->addContractorOrder($dto->order_unit_id, $dto->organization_order_units_invoce_id);


            //Что бы получить bool значение из модели
            $model->refresh();

            return $model;

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
    private function addContractorOrder(string $order_id, string $agreement_order_id) : bool
    {

        try {

            /**
            * @var OrganizationOrderUnitInvoice
            */
            $organizationOrderUnitInvoiceModel = $this->organizationOrderUnitInvoiceRep->get($agreement_order_id);

            /**
            * @var InvoiceOrder
            */
            $invoiceOrder = $organizationOrderUnitInvoiceModel->invoice_order;

            /**
            * @var OrderUnit
            */
            $order = $this->orderUnitRep->get($order_id);

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
}
