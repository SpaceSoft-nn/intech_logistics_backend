<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Status;

use App\Modules\IndividualPeople\App\Repositories\IndividualPeopleRepository;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;
use App\Modules\OrderUnit\Domain\Services\TransportationStatusService;
use App\Modules\Transport\Domain\Models\Transport;
use DB;
use Exception;

use function App\Helpers\isNullToBusinessException;

class ParseEmailAndChangeTransportStatusInteractor
{

    public function __construct(
        private OrderUnitRepository $orderUnitRepository,
        private IndividualPeopleRepository $individualPeopleRepository,
        private TransportationStatusService $transportationStatusService,
    ) {}

    public function execute(string $email) : ?TransporationStatus
    {
        return $this->run($email);
    }

    private function run(string $email) : ?TransporationStatus
    {
        #TODO Пересмотреть логику получение заказа + работу сервеса отправлять в очередь

        {
            /**
             * @var ?IndividualPeople
             */
            $individualPeople = $this->getIndividualPeopleForEmail($email);


            /**
             * @var ?DriverPeople
             */
            $driverPeople = $this->getDriverPeopleForIndividualPeople($individualPeople);

            /**
             * @var Transport
             */
            $transport = $this->getTransportForDriverPeople($driverPeople);

            /**
             * @var OrderUnit
             */
            $order = $this->getOrderUnitAndInWorkForTransport($transport);

            /**
             * @var ?TransporationStatus
             */
            $status = $this->transportationStatusService->setTransportationStatus($order->id);
        }

        return $status;

    }

    private function getIndividualPeopleForEmail(string $email) : ?IndividualPeople
    {

        $model = $this->individualPeopleRepository->findByEmail($email);

        isNullToBusinessException($model, "Не найден Individual People по значению email: {$email}", 404);

        return $model;

    }

    private function getDriverPeopleForIndividualPeople(IndividualPeople $individualPeople) : DriverPeople
    {
        $model = $individualPeople->driverPeople;

        isNullToBusinessException($model, "Не найден driver People по значению связи individual People : {$individualPeople}", 404);

        return $model;
    }

    private function getTransportForDriverPeople(DriverPeople $driverPeople) : ?Transport
    {
        //проверка
        $model = $driverPeople->transport;

        isNullToBusinessException($model, "Не найден Transport по значению связи с Driver People: {$driverPeople}", 404);

        return $model;
    }

    private function getOrderUnitAndInWorkForTransport(Transport $transport) : ?OrderUnit
    {
        //проверка
        $model = $this->orderUnitRepository->getOrderUnitAndStatusInWork($transport->id);

        isNullToBusinessException($model, "Не найден Order Unit по значению связи с Transport, с условие, что заказ должен быть в Работе: {$transport}", 404);

        return $model;
    }

}
