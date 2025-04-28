<?php

namespace App\Modules\Transport\Domain\Service;

use Illuminate\Support\Collection;
use App\Modules\Transport\Domain\Interface\Service\ITransportService;
use App\Modules\Transport\Domain\Models\TransportationStatusСalendar;
use App\Modules\Transport\Domain\Interactor\CreateTransportationStatusCalendar;
use App\Modules\Transport\Domain\Interactor\ParseDataForTransportationStatusCalendar;

class TransportService implements ITransportService
{

    public function __construct(
        private CreateTransportationStatusCalendar $createTransportationStatusCalendar,
        private ParseDataForTransportationStatusCalendar $parseDataForTransportationStatusCalendar,
    ) { }


    /**
     * Получаем коллекцию статусов "на погрузке, на разгрузке, в пути" у транспорта (по персональному лицу)
     * @param string $email
     *
     * @return Collection<TransportationStatusСalendar>
    */
    public function createTransportationStatusCalendar(string $email) : Collection
    {
        return $this->parseDataForTransportationStatusCalendar->execute($email);
    }
}
