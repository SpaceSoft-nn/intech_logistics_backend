<?php

namespace App\Modules\OrderUnit\Domain\Actions\Agreement;

use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;

class AgreementOrderAcceptCreateAction
{

    private ?bool $order_bool = null;
    private ?bool $contractor_bool = null;

    public function __construct(
        public string $agreement_order_id
    ) {
        return $this->run();
    }


    /**
    * order_bool = True, подтверждения со стороны заказчика
    */
    public function setAcceptOrder() : self
    {
        $this->order_bool = true;

        return $this;
    }

      /**
    * order_bool = True, подтверждения со стороны подрядчика
    */
    public function setAcceptContractor() : self
    {
        $this->contractor_bool = true;

        return $this;
    }

    /**
     *
     * @return ?AgreementOrderAccept
     */
    private function run() : ?AgreementOrderAccept
    {

        $model = AgreementOrderAccept::find($this->agreement_order_id);

        if($model) { return null; }

        //#TODO Это нужно в updated
        //Меняем значение bool сохраняем в бд
        if($this->order_bool) { $model->order_bool = $this->order_bool; $model->save(); }
        if($this->contractor_bool) { $model->contractor_bool = $this->contractor_bool;  $model->save(); }


        return $model;
    }
}
