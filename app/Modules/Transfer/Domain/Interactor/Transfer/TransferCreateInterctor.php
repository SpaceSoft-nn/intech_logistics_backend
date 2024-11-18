<?php

namespace App\Modules\Transfer\Domain\Interactor\Transfer;

use App\Modules\Base\Error\BusinessException;
use App\Modules\InteractorModules\AgreementTransfer\App\Data\DTO\LinkAgreementToTransferDTO;
use App\Modules\InteractorModules\AgreementTransfer\Domain\Actions\LinkAgreementToTransferAction;
use App\Modules\OrderUnit\App\Repositories\AgreementOrderRepository;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\Transfer\App\Data\DTO\Transfer\CreateTransferServiceDTO;
use App\Modules\Transfer\App\Data\ValueObject\TransferVO;
use App\Modules\Transfer\Domain\Actions\Transfer\TransferCreateAction;
use App\Modules\Transfer\Domain\Models\Transfer;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Collection;

/**
 * Объединение создание логики transfer с остальными таблицами/моделями
 */
class TransferCreateInterctor
{

    /**
    * @var Collection
    */
    private Collection $agreementOrders;

    public function __construct(
        private OrderUnitService $orderService,
        private AgreementOrderRepository $agrOrderReposiotry,
        private OrderUnitRepository $orderUnitRepository,
    ) { }

    public function execute(CreateTransferServiceDTO $dto)
    {
        return $this->InteractorLogic($dto);
    }


    private function InteractorLogic(CreateTransferServiceDTO $dto) : ?Transfer
    {
        #TODO Здесь нужно использовать паттерн handler (цепочка обязанностей)

        //получаем agreementOrders в свойства класса $agreementOrders
        $this->setAgreementOrders($dto->agreementOrder_id);

        //создаём transfer
        {

        /**
         * @var TransferVO
        */
        $vo = $this->createTransferVO($dto);


        /**
         * @var Transfer
        */
        $transfer = $this->createTransfer($vo);
        if(!$transfer) { throw new Exception("Ошибка в TransferCreateInterctor, при создании transfer", 500); }
        }

        //привязываем AgreementOrder к transfer
        {
            $this->linkAgreementTransfer($transfer , $dto->main_order_id);
        }

        return $transfer;


        try {

            return DB::transaction(function ($pdo) use ($dto) {

                //получаем agreementOrders в свойства класса $agreementOrders
                $this->setAgreementOrders($dto->agreementOrder_id);

                //создаём transfer
                {

                /**
                 * @var TransferVO
                 */
                $vo = $this->createTransferVO($dto);


                /**
                 * @var Transfer
                 */
                $transfer = $this->createTransfer($vo);
                if(!$transfer) { throw new Exception("Ошибка в TransferCreateInterctor, при создании transfer", 500); }
                }

                //привязываем AgreementOrder к transfer
                {
                    $this->linkAgreementTransfer($transfer , $dto->main_order_id);
                }

                return $transfer;

            });

        } catch (\Throwable $th) {

            throw new Exception('Ошибка в интеракторе TransferCreateInterctor', 500);

        }

    }

    private function setAgreementOrders(array $agreementOrder_id)
    {
        $modelsAgreementOrder = AgreementOrder::find($agreementOrder_id);
        $modelsAgreementOrder ?? throw new Exception('Не найденны никакие заявки AgreementOrder', 404);

        $this->agreementOrders = $modelsAgreementOrder;
    }

    private function createTransferVO(CreateTransferServiceDTO $dto) : ?TransferVO
    {

        /**
         * @var OrderUnit
         */
        $order_main = null;

        $arrayCollection = [];

        foreach ($this->agreementOrders as $agreementOrder) {

            //проверяем сущестувет ли связь с главным заказом и получаем его
            if($this->agrOrderReposiotry->isMainOrder($agreementOrder, $dto->main_order_id))
            {
                $order_main = $agreementOrder->order;
            }

            $arrayCollection[] = $agreementOrder->order;

        }

        $order_main ?? throw new BusinessException('Не найдено подтверждения между сторонами главного заказа.', 404);

        //получаем через репозиторий адресс начала и конца в связки по приоритености (т.е главный заказ)
        $address_start = $this->orderUnitRepository->firstPivotPriorityAddress($order_main);
        $address_end = $this->orderUnitRepository->lastPivotPriorityAddress($order_main);



        //TODO Может быть баг - когда адрессов много у заказа (или же когда у адресса может быть множество заказов)
        /**
        * @var TransferVO $vo
        */
        $transferVO = TransferVO::make(
            transport_id: $dto->transferDTO->transport_id,
            delivery_start: $address_start->order_units->first()->pivot->data_time, // может случится баг (делать проверку на заказ) у Адресса много заказов
            delivery_end: $address_end->order_units->first()->pivot->data_time, //может случится баг (делать проверку на заказ) у Адресса много заказов
            address_start_id: $address_start->id,
            address_end_id: $address_end->id,
            order_total: $this->orderService->calcultTotalOrders(collect($arrayCollection)),
            description: $dto->transferDTO->description,
            body_volume: $this->orderService->calcultBodyBolumeOrders(collect($arrayCollection)),
        );

        return $transferVO;
    }

    private function createTransfer(TransferVO $vo) : ?Transfer
    {
        return TransferCreateAction::make($vo);
    }


    /**
     * Линкуем связь многие ко многим Transfer и Order Agreement
     * @param array $agreementOrder_id
     * @param Transfer $transfer
     * @param string $order_main
     *
     * @return bool
     */
    private function linkAgreementTransfer(Transfer $transfer , string $order_main) : bool
    {
        $models = $this->agreementOrders;

        $status = false;

        if($models)
        {

            foreach ($models as $model) {

                $statusOrderMain = (bool) $model->order_unit_id == $order_main;

                $status = LinkAgreementToTransferAction::run(
                    LinkAgreementToTransferDTO::make(
                        agreementOrder: $model,
                        transfer: $transfer,
                        order_main: $statusOrderMain ,
                    )
                );

            }

        } else {

            throw new Exception('Не найденно не одной модели Agreement Order', 500);

        }

        return $status;

    }

    private function linkCargoUnit()
    {
        #TODO - Сделать логику линковки cargoUnit и Transfer
        return 'cargo';
    }
}
