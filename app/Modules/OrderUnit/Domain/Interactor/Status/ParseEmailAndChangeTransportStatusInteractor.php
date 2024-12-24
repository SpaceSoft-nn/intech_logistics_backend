<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Status;

use App\Modules\IndividualPeople\App\Repositories\IndividualPeopleRepository;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Services\TransportationStatusService;
use App\Modules\Transport\Domain\Models\Transport;
use DB;


class ParseEmailAndChangeTransportStatusInteractor
{

    public function __construct(
        private OrderUnitRepository $orderUnitRepository,
        private IndividualPeopleRepository $individualPeopleRepository,
        private TransportationStatusService $transportationStatusService,
    ) {}

    public function execute(string $email)
    {
        return $this->run($email);
    }

    private function run(string $email)
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

            dd($order);

            $status = $this->transportationStatusService->setTransportationStatus($order->id);
        }

        dd($status);


    }

    private function getIndividualPeopleForEmail(string $email) : ?IndividualPeople
    {
        //проверку
        return $this->individualPeopleRepository->findByEmail($email);
    }

    private function getDriverPeopleForIndividualPeople(IndividualPeople $individualPeople) : DriverPeople
    {
        //проверка
        return $individualPeople->driverPeople;
    }

    private function getTransportForDriverPeople(DriverPeople $driverPeople) : ?Transport
    {
        //проверка
        return $driverPeople->transport;
    }

    private function getOrderUnitAndInWorkForTransport(Transport $transport) : ?OrderUnit
    {
        //проверка
        return $this->orderUnitRepository->getOrderUnitAndStatusInWork($transport->id);
    }

}
