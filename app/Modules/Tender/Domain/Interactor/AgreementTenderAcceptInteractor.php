<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\OrderUnit\App\Data\DTO\OrderUnit\OrderUnitCreateDTO;
use App\Modules\OrderUnit\App\Data\DTO\ValueObject\OrderUnit\OrderUnitVO;
use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Services\OrderUnitService;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTender;
use App\Modules\Tender\Domain\Models\Response\AgreementTenderAccept;
use DB;
use Illuminate\Support\Carbon;

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
        if($agreementTenderAccept->tender_creater_bool && $agreementTenderAccept->contractor_bool)
        {

            /** @var AgreementTender */
            $agreement_tender = $agreementTenderAccept->agreement_tender;

            /** @var LotTender */
            $lot_tender = $agreement_tender->lot_tender;

              //если есть конкретно указаные даты.
            if($lot_tender->specifica_date_period)
            {

                $dates = $lot_tender->specifica_date_period;


                DB::transaction(function () use ($dates, $lot_tender, $agreement_tender) {

                    //проходим по дате
                    foreach ($dates as $date) {

                        { //Высчитывает дату
                            $carbon_date_start = Carbon::createFromFormat('d,m,Y', $date);

                            //получем конечную дату в зависимости от периода #TODO Потом нужно устанавливать в зависимости от километража
                            $carbon_date_end = $carbon_date_start->addDays($lot_tender->period);
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
                                user_id: null, #TODO Продумать логику при ролях, как указывать правильно
                                contractor_id: $agreement_tender->organization_contractor_id, //указываем подрядчика на выполнения заказа
                                lot_tender_id: $lot_tender->id,
                                add_load_space: false, #TODO Продумать что тут указывать?
                            );


                            //создаём заказы
                            $this->orderUnitService->createOrderUnit(
                                dto: OrderUnitCreateDTO::make(orderUnitVO: $orderUnitVO)
                            );

                        }

                    }

                });


            } else { //если нету конкретных дат

                { //Высчитывает дату
                    $carbon_date_start = Carbon::createFromFormat('d,m,Y', $lot_tender->date_start);

                    //получем конечную дату в зависимости от периода #TODO Потом нужно устанавливать в зависимости от километража
                    $carbon_date_end = $carbon_date_start->addDays($lot_tender->period);
                }

                $orderUnitVO = OrderUnitVO::make(
                    end_date_order: $carbon_date_end->toDateString(),
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
                $this->orderUnitService->createOrderUnit(
                    dto: OrderUnitCreateDTO::make(orderUnitVO: $orderUnitVO)
                );


            }


        }


        return $agreementTenderAccept;

    }

    /**
     * Маппим OrderUnitVO из AgreementTenderAccept
     * @param AgreementTenderAccept $agreementTenderAccept
     *
     * @return OrderUnitVO
    */
    private function mappingOrderUnitVO(LotTender $lot_tender, AgreementTenderAccept $agreementTenderAccept) : OrderUnitVO
    {



        return $orderUnitVO;
    }




}
