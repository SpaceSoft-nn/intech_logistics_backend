<?php

namespace App\Modules\Transport\Domain\Interactor;

use App\Modules\Base\Error\BusinessException;
use Illuminate\Support\Collection;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Transport\Domain\Models\Transport;
use function App\Helpers\isNullToBusinessException;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use App\Modules\IndividualPeople\Domain\Models\IndividualPeople;

use App\Modules\OrderUnit\Domain\Models\Status\TransporationStatus;
use App\Modules\Transport\Domain\Models\TransportationStatusСalendar;
use App\Modules\IndividualPeople\App\Repositories\IndividualPeopleRepository;

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
    public function execute(?string $email = null, ?string $phone = null) : Collection
    {
        return $this->run($email, $phone);
    }

    /**
     * @param string $email
     *
     * @return ?Collection<TransportationStatusСalendar>
     */
    private function run(?string $email = null, ?string $phone = null) : ?Collection
    {
        #TODO Пересмотреть логику получение заказа + работу сервиса отправлять в очередь

        {
            /**
             * @var ?IndividualPeople
             */
            $individualPeople = $this->getIndividualPeopleForEmail($email, $phone);

            //если значение на найдено возвращаем пустую коллекцию
            if(is_null($individualPeople)) { return collect([]); }


            /**
             * @var ?DriverPeople
             */
            $driverPeople = $this->getDriverPeopleForIndividualPeople($individualPeople);

            //если значение на найдено возвращаем пустую коллекцию
            if(is_null($driverPeople)) { return collect([]); }

            /**
             * @var Transport
             */
            $transport = $this->getTransportForDriverPeople($driverPeople);

            //если значение на найдено возвращаем пустую коллекцию
            if(is_null($transport)) { return collect([]); }

            /**
             * @var OrderUnit
             */
            $order = $this->getOrderUnitAndInWorkForTransport($transport);

            //если значение на найдено возвращаем пустую коллекцию
            if(is_null($order)) { return collect([]); }

            /**
            * @var Collection
            */
            $statuses = $this->createTransportationStatusCalendar->execute($order->id);
        }

        return $statuses;

    }

    private function getIndividualPeopleForEmail(?string $email = null, ?string $phone = null) : ?IndividualPeople
    {

        if($email)
        {
            $model = $this->individualPeopleRepository->findByEmail($email);


        } else if ($phone){

            $model = $this->individualPeopleRepository->findByPhone($phone);

        } else {
            //если не найден водитель
            return null;
        }

        return $model;
    }

    private function getDriverPeopleForIndividualPeople(IndividualPeople $individualPeople) : ?DriverPeople
    {

        $model = $individualPeople->individualable;

        if(is_null($model)) { return null; }

        // isNullToBusinessException($model, "Не найден Driver People по значению связи individual People : {$individualPeople}, либо он не является нужным типом по morph", 404);

        return $model;
    }

    private function getTransportForDriverPeople(DriverPeople $driverPeople) : ?Transport
    {

        //проверка
        $model = $driverPeople->transport;

        // isNullToBusinessException($model, "Не найден Transport по значению связи с Driver People: {$driverPeople}", 404);

        if(is_null($model)) { return null; }

        return $model;
    }

    private function getOrderUnitAndInWorkForTransport(Transport $transport) : ?OrderUnit
    {
        //проверка
        $model = $this->orderUnitRepository->getOrderUnitAndStatusInWork($transport->id);

        if(is_null($model)) { return null; }

        // if(is_null($model)) { throw new BusinessException('Не найден Order Unit по значению связи с Transport, с условие, что заказ должен быть в Работе: {$transport}', 404); }

        return $model;
    }

}
