<?php

namespace App\Modules\Transport\Domain\Interactor;


use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Transport\Domain\Models\Transport;
use function App\Helpers\isNullToBusinessException;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;
use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;

use App\Modules\Transport\Domain\Models\TransportationStatusСalendar;
use App\Modules\IndividualPeople\App\Repositories\IndividualPeopleRepository;
use Illuminate\Support\Collection;

class ParseDataForTransportationStatusCalendar
{

    public function __construct(
        private OrderUnitRepository $orderUnitRepository,
        private IndividualPeopleRepository $individualPeopleRepository,
        private CreateTransportationStatusCalendar $createTransportationStatusCalendar,
    ) {}

    /**
     * @param string $email
     *
     * @return Collection<TransportationStatusСalendar>
     */
    public function execute(string $email) : Collection
    {
        return $this->run($email);
    }

    /**
     * @param string $email
     *
     * @return Collection<TransportationStatusСalendar>
     */
    private function run(string $email) : Collection
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
            * @var Collection
            */
            $statuses = $this->createTransportationStatusCalendar->execute($order->id);
        }

        return $statuses;

    }

    private function getIndividualPeopleForEmail(string $email) : ?IndividualPeople
    {

        $model = $this->individualPeopleRepository->findByEmail($email);

        isNullToBusinessException($model, "Не найден Individual People по значению email: {$email}", 404);

        return $model;

    }

    private function getDriverPeopleForIndividualPeople(IndividualPeople $individualPeople) : DriverPeople
    {

        $model = $individualPeople->individualable;

        isNullToBusinessException($model, "Не найден Driver People по значению связи individual People : {$individualPeople}, либо он не является нужным типом по morph", 404);

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
