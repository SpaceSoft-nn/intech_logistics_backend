<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Agreement;

use App\Modules\OrderUnit\App\Data\DTO\Agreement\AgreementOrderCreateDTO;
use App\Modules\OrderUnit\Domain\Actions\Agreement\AgreementOrderAcceptCreateAction;
use App\Modules\OrderUnit\Domain\Actions\Agreement\AgreementOrderCreateAction;
use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\OrderUnit\Domain\Models\AgreementOrderAccept;
use DB;
use Exception;

class AgreementOrderInteractor
{

    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrderAccept
     */
    public static function execute(AgreementOrderCreateDTO $dto) : ?AgreementOrderAccept
    {
        return (new self())->run($dto);
    }

    /**
     * @param AgreementOrderCreateDTO $dto
     *
     * @return ?AgreementOrderAccept
     */
    public function run(AgreementOrderCreateDTO $dto) : ?AgreementOrderAccept
    {

        $agreementOrderCreate = $this->agreementOrderCreate($dto);

        $model = $this->agreementOrderAcceptCreate($agreementOrderCreate->id);

        //Что бы получить bool значение из модели
        $model->refresh();

        return $model;

    }

    private function agreementOrderAcceptCreate(string $agreement_order_id) : ?AgreementOrderAccept
    {
        return AgreementOrderAcceptCreateAction::make($agreement_order_id);
    }

    private function agreementOrderCreate(AgreementOrderCreateDTO $dto) : ?AgreementOrder
    {
        return AgreementOrderCreateAction::make($dto);
    }
}
