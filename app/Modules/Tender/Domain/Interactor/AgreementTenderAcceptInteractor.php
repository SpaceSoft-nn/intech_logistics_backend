<?php

namespace App\Modules\Tender\Domain\Interactor;

use DB;
use Str;
use Illuminate\Support\Carbon;
use App\Modules\Base\Enums\WeekEnum;
use App\Modules\Base\Error\BusinessException;
use App\Modules\User\Domain\Models\User;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\Tender\Domain\Models\Response\InvoiceLotTender;
use App\Modules\Tender\Domain\Models\SpecificalDatePeriod;

// Бизнес логика на согласование Тендера с двух сторон - здесь же создаются заказы (pre-order)
final class AgreementTenderAcceptInteractor
{

    public function __construct(
        private OrderUnitService $orderUnitService,
    ) { }


    public function execute(User $user, AgreementTenderAccept $agreementTenderAccept) : Object
    {

        if($agreementTenderAccept->tender_creater_bool && $agreementTenderAccept->contractor_bool) { return $this->response(true, 'Заявки уже были успешно подтверждены с двух сторон.', $agreementTenderAccept); }

        $statusResponse = $this->run($user, $agreementTenderAccept);

        //проверяем что есть двух стороняя подпись и создаём заказы в зависимости от типа тендера
        $this->checkSignatureAndCreateOrder($agreementTenderAccept);

        return $statusResponse;
    }


    public function run(User $user, AgreementTenderAccept $agreementTenderAccept) : Object
    {
        $object = DB::transaction(function ($pdo)  use ($user, $agreementTenderAccept) {

            /** @var AgreementTender */
            $agreement_tender = $agreementTenderAccept->agreement_tender;

            /** @var LotTender */
            $lot_tender = $agreement_tender->lot_tender;

            //проверяем что запрос был от заказчика
            {

                if(!empty($lot_tender->organization_id)) {

                    foreach ($user->organizations as $organization) {

                        if($lot_tender->organization_id == $organization->id)
                        {

                            if( $agreementTenderAccept->tender_creater_bool ) { return $this->response(true, "Заказчик успешно согласовал выполнение тендера.", $agreementTenderAccept); }

                            $agreementTenderAccept->tender_creater_bool = true;
                            $agreementTenderAccept->save();

                            return $this->response(true, "Заказчик успешно согласовал выполнение тендера.", $agreementTenderAccept);
                        }
                    }

                }

                #TODO В тендер проверять не только по оргаанизации но и по user кто создавла тендер
                // if(!empty($order->user_id))
                // {
                //     if($order->user_id == $user->id)
                //     {

                //         return $this->response( true, "Заказчик успешно согласовал выполнение тендера.", $agreementOrderAccept);
                //     }
                // }
            }

            //проверяем что запрос был от подрядчика
            {

                if(!empty($agreement_tender->organization_contractor_id))
                {

                    foreach ($user->organizations as $organizations) {

                        if($agreement_tender->organization_contractor_id == $organizations->id)
                        {

                            if($agreementTenderAccept->contractor_bool) { return $this->response(true, 'Перевозчик успешно согласовал выполнение тендера.', $agreementTenderAccept); }

                            $agreementTenderAccept->contractor_bool = true;
                            $agreementTenderAccept->save();

                            return $this->response(true, 'Перевозчик успешно согласовал выполнение тендера.', $agreementTenderAccept);
                        }
                    }
                }
            }

            return $this->response(false, 'У данного пользователя нет прав на согласования заказа.');
        });

        return $object;
    }


    private function response(bool $status, string $message, ?AgreementTenderAccept $agreementAccept = null) : Object
    {

        return (object) [
            'data' => $agreementAccept,
            'status' => $status,
            'message' => $message,
        ];
    }

    private function checkSignatureAndCreateOrder(AgreementTenderAccept $agreementTenderAccept) : bool
    {

        if($agreementTenderAccept->tender_creater_bool && $agreementTenderAccept->contractor_bool)
        {


            /** @var AgreementTender */
            $agreement_tender = $agreementTenderAccept->agreement_tender;

            DB::transaction(function () use ($agreement_tender) {

                /** @var LotTender lockForUpdate - блокируем для обновления */
                $lot_tender = $agreement_tender->lot_tender()->lockForUpdate()->first();

                /** @var InvoiceLotTender */
                $invoceLotTender = $agreement_tender->lot_tender_response->invoice_lot_tender;


                //если есть конкретно указаные даты.
                if($lot_tender->specifical_date_period->isNotEmpty())
                {

                    /** @var SpecificalDatePeriod[] */
                    $dates = $lot_tender->specifical_date_period;

                    //проходим по дате
                    foreach ($dates as $date) {


                        { //Высчитывает дату

                            //из-за того что у нас стоят cast на RU формат времени, нужно делать преобразования
                            $carbon_date_start = Carbon::createFromFormat('d.m.Y', $date->date);


                            //получем конечную дату в зависимости от периода #TODO Потом нужно устанавливать в зависимости от километража
                            $carbon_date_end = $carbon_date_start->copy()->addDays($lot_tender->period);

                            //переводим в нужный формат что бы через касты добавилось в БД
                            $carbon_date_end = $carbon_date_end->format('d.m.Y');
                            $carbon_date_start = $carbon_date_start->format('d.m.Y');
                        }


                        //у каждой даты, есть количество транспорта, который равен: транспорт = заказ
                        for ($i = 0; $i < $date->count_transport; $i++) {

                            $orderUnitVO = OrderUnitVO::make(
                                end_date_order: $carbon_date_end,
                                body_volume: $lot_tender->body_volume_for_order,
                                order_status: StatusOrderUnitEnum::pre_order->value,
                                order_total: $invoceLotTender->price_for_km,
                                type_transport_weight: $lot_tender->type_transport_weight->value,
                                type_load_truck: $lot_tender->type_load_truck->value,
                                organization_id: $lot_tender->organization_id,
                                transport_id: $invoceLotTender->transport_id,
                                description: null,
                                user_id: null, #TODO Продумать логику при ролях, как указывать правильно
                                contractor_id: $agreement_tender->organization_contractor_id, //указываем подрядчика на выполнения заказа
                                add_load_space: false, #TODO Продумать что тут указывать?
                                offer_contractor_id: null,
                                lot_tender_id: $lot_tender->id,
                            );


                            // //создаём заказы
                            $order_unit = $this->orderUnitService->createOrderUnit(
                                dto: OrderUnitCreateDTO::make(orderUnitVO: $orderUnitVO)
                            );


                            $array[] =  $order_unit;

                        }

                    }


                }

                //Если установлена периодичность
                if($lot_tender->week_period->isNotEmpty())
                {

                    { //Высчитывает дату

                        //устанавливаем время локализации ру
                        Carbon::setLocale('ru');

                        //получаем начальную дату
                        $carbon_date_start = Carbon::createFromFormat('d.m.Y', $lot_tender->date_start);

                        //получем конечную дату в зависимости от периода #TODO Потом нужно устанавливать в зависимости от километража
                        $carbon_date_end = $carbon_date_start->copy()->addDays($lot_tender->period);

                        $currentDate = $carbon_date_start->copy(); // копируем дату - работаем с новым объектом и проходимся по нему

                        while ($currentDate->lte($carbon_date_end)) {

                            //Получаем название недели в ру - мапим в Enum, значение переводим в заглавную букву.
                            $weekCarbonToEnum = WeekEnum::from(Str::ucfirst($currentDate->copy()->translatedFormat('l')));


                            foreach ($lot_tender->week_period as $object) {

                                // Проверяем, является ли текущий день недели нужным
                                if ( $weekCarbonToEnum === $object->value )
                                {
                                    $resultDates[] = $currentDate->format('d-m-Y'); // Добавляем дату в массив
                                }

                            }

                            $currentDate->addDay(); // Переходим к следующему дню

                        }

                    }

                    //создаём заказы в заависимости от указанных дней недели + перодности (например 60) и понедельник
                    foreach ($resultDates as $date) {

                        $orderUnitVO = OrderUnitVO::make(
                            end_date_order: $carbon_date_end->toDateString(),
                            exemplary_date_start: $date,
                            body_volume: $lot_tender->body_volume_for_order,
                            order_status: StatusOrderUnitEnum::pre_order->value,
                            order_total: $invoceLotTender->price_for_km,
                            type_transport_weight: $lot_tender->type_transport_weight->value,
                            type_load_truck: $lot_tender->type_load_truck->value,
                            organization_id: $lot_tender->organization_id,
                            transport_id: $invoceLotTender->transport_id,
                            user_id: null, #TODO Продумать логику при ролях, как указывать правильно
                            contractor_id: $agreement_tender->organization_contractor_id, //указываем подрядчика на выполнения заказа
                            add_load_space: false, #TODO Продумать что тут указывать?
                            offer_contractor_id: null,
                            lot_tender_id: $lot_tender->id,
                        );

                        //создаём заказы
                        $order_unit = $this->orderUnitService->createOrderUnit(
                            dto: OrderUnitCreateDTO::make(orderUnitVO: $orderUnitVO)
                        );

                    }

                }

                $lot_tender->status_tender = StatusTenderEnum::in_work; #TODO Решить потом какой статус ставить?
                $lot_tender->save();

            });

            return false;

        } else {
            return false;
        }

    }

}
