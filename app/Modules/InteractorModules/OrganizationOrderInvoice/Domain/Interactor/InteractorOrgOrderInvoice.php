<?php

namespace App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Interactor;

use App\Modules\Base\Error\BusinessException;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\DTO\OrgOrderInvoiceCreateDTO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\App\Data\ValueObject\OrderInvoice\InvoiceOrderVO;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Actions\OrderInvoice\InvoiceOrderCreateAction;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Actions\OrganizationOrderUnitInvoice\OrganizationOrderUnitInvoiceCreateAction;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\InvoiceOrder;
use App\Modules\InteractorModules\OrganizationOrderInvoice\Domain\Models\OrganizationOrderUnitInvoice;
use DB;
use Exception;

use function App\Helpers\Mylog;

class InteractorOrgOrderInvoice
{
    // public function __construct(
    //     private OrganizationOrderInvoiceService $service
    // ) {}

    /**
     * @param OrgOrderInvoiceCreateDTO $dto
     *
     * @return OrganizationOrderUnitInvoice
     */
    public static function excexute(OrgOrderInvoiceCreateDTO $dto) : OrganizationOrderUnitInvoice
    {
        return (new self())->run($dto);
    }

    /**
     * Запуск работы бизнес логики
     * @param OrgOrderInvoiceCreateDTO $dto
     *
     * @return OrganizationOrderUnitInvoice
     */
    private function run(OrgOrderInvoiceCreateDTO $dto) : OrganizationOrderUnitInvoice
    {

        try {

            /**
             * @var OrganizationOrderUnitInvoice
            */
            $model = DB::transaction(function ($pdo) use ($dto) {

                //создаём некую документацию от исполнителя, для заказчика - выбравший Заказ
                $modelInvoce = $this->createInvoiceOrder($dto->invoiceOrderVO);

                /**
                * @var OrganizationOrderUnitInvoice
                */
                $model = $this->createOrgOrderInvoice(
                    orderId: $dto->order->id,
                    orgId: $dto->organization->id,
                    invoiceId: $modelInvoce->id,
                );

                #TODO Убедиться что не нужна, и удалить.
                //Добавляем cotractor к OrederUnit
                // $this->addContractorOrder($dto->order, $dto->organization->id);

                return $model;

            });

            return $model;

        }
        catch (BusinessException $e) {

            //ловим заказ и ещё раз выкидываем ошибку. т.к $e ловит нашу ошибку из сервеса глубже и переопределяем.
            throw new BusinessException($e->getCustomMessage(), 422);

        } catch (\Exception $e) {

            Mylog('Ошибка в InteractorOrgOrderInvoice: ' . $e);
            throw new Exception('Ошибка транзакции в интеракторе: InteractorOrgOrderInvoice', 500);

        }

    }

    /**
     * Создание OrderInvoice
     * @param InvoiceOrderVO $vo
     *
     * @return ?InvoiceOrder
    */
    private static function createInvoiceOrder(InvoiceOrderVO $vo) : ?InvoiceOrder
    {
        //Выносит в отдельный сервес
        return InvoiceOrderCreateAction::make($vo);
    }


    /**
     * Создание записи в таблице organization_order_units_invoce
     * @return ?OrganizationOrderUnitInvoice
    */
    private static function createOrgOrderInvoice(string $orderId, string $orgId, string $invoiceId) : ?OrganizationOrderUnitInvoice
    {
        return OrganizationOrderUnitInvoiceCreateAction::make($orderId, $orgId, $invoiceId);
    }

    /**
     * #TODO Лишняя логика? Потом удалить
     * Добавляем contractor_id к Order
     * @return bool
     */
    // private function addContractorOrder(OrderUnit $order, string $organization_id) : bool
    // {

    //     $order->contractor_id = $organization_id;

    //     return $order->save() ? true : false;
    // }
}
