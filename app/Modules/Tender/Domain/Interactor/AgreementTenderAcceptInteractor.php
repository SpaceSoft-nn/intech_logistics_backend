<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\Base\Enums\WeekEnum;
use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use DB;
use Illuminate\Support\Carbon;
use Str;

// Бизнес логика на согласование Тендера с двух сторон - здесь же создаются заказы (pre-order)
final class AgreementTenderAcceptInteractor
{

    public function __construct(
        private OrderUnitService $orderUnitService,
    ) { }


    public function execute(AgreementTenderAccept $agreementTenderAccept) : AgreementTenderAccept
    {
        return $this->run($agreementTenderAccept);
    }


    public function run(AgreementTenderAccept $agreementTenderAccept) : AgreementTenderAccept
    {

        #TODO Временная логика - устанавливаем bool с двух сторон
        $agreementTenderAccept->tender_creater_bool = true;
        $agreementTenderAccept->contractor_bool = true;
        #TODO - Создание заказов

        $agreementTenderAccept->save();


        //проверять что соглашения подписаны с обоих сторон
        // if($agreementTenderAccept->tender_creater_bool && $agreementTenderAccept->contractor_bool)
        if(true)
        {
            /** @var AgreementTender */
            $agreement_tender = $agreementTenderAccept->agreement_tender;

            DB::transaction(function () use ($agreement_tender) {

                /** @var LotTender lockForUpdate - блокируем для обновления */
                $lot_tender = $agreement_tender->lot_tender->lockForUpdate()->first();


                //если есть конкретно указаные даты.
                if($lot_tender->specifica_date_period)
                {

                    $dates = $lot_tender->specifica_date_period;

                    //проходим по дате
                    foreach ($dates as $date) {

                        { //Высчитывает дату
                            $carbon_date_start = Carbon::createFromFormat('Y-m-d', $date->date, 'Europe/Moscow');

                            //получем конечную дату в зависимости от периода #TODO Потом нужно устанавливать в зависимости от километража
                            $carbon_date_end = $carbon_date_start->copy()->addDays($lot_tender->period);

                        }

                        //у каждой даты, есть количество транспорта, который равен: транспорт = заказ
                        for ($i = 0; $i < $date->count_transport; $i++) {

                            $orderUnitVO = OrderUnitVO::make(
                                end_date_order: $carbon_date_end->toDateString(),
                                body_volume: $lot_tender->body_volume_for_order,
                                order_status: StatusOrderUnitEnum::pre_order->value,
                                order_total: $lot_tender->price_for_km,
                                type_transport_weight: $lot_tender->type_transport_weight->value,
                                type_load_truck: $lot_tender->type_load_truck->value,
                                organization_id: $lot_tender->organization_id,
                                description: null,
                                user_id: null, #TODO Продумать логику при ролях, как указывать правильно
                                contractor_id: $agreement_tender->organization_contractor_id, //указываем подрядчика на выполнения заказа
                                lot_tender_id: $lot_tender->id,
                                add_load_space: false, #TODO Продумать что тут указывать?
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
                if($lot_tender->week_period)
                {

                    { //Высчитывает дату

                        //устанавливаем время локализации ру
                        Carbon::setLocale('ru');

                        //получаем начальную дату
                        $carbon_date_start = Carbon::createFromFormat('Y-m-d', $lot_tender->date_start);

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
                            order_total: $lot_tender->price_for_km,
                            type_transport_weight: $lot_tender->type_transport_weight->value,
                            type_load_truck: $lot_tender->type_load_truck->value,
                            organization_id: $lot_tender->organization_id,
                            user_id: null, #TODO Продумать логику при ролях, как указывать правильно
                            contractor_id: $agreement_tender->organization_contractor_id, //указываем подрядчика на выполнения заказа
                            lot_tender_id: $lot_tender->id,
                            add_load_space: false, #TODO Продумать что тут указывать?
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

        }

        return $agreementTenderAccept;

    }


}
