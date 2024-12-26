<?php

namespace App\Modules\Tender\Domain\Interactor;

use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\App\Data\ValueObject\AgreementDocumentTenderVO;
use App\Modules\Tender\App\Data\ValueObject\ApplicationDocumentTenderVO;
use App\Modules\Tender\App\Data\ValueObject\CreateSpecificalDatePeriodAction;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\Tender\App\Data\ValueObject\SpecificalDatePeriodVO;
use App\Modules\Tender\Domain\Actions\Document\CreateAgreementDocumentTenderAction;
use App\Modules\Tender\Domain\Actions\Document\CreateApplicationDocumentTenderAction;
use App\Modules\Tender\Domain\Actions\LotTender\CreateLotTenderAction;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Tender\Domain\Models\ApplicationDocumentTender;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\SpecificalDatePeriod;
use DB;

/**
 * Интерактор для создание LotTender - так же логика добавление файлов + адрессов к LotTender
 */
final class CreateLotTenderInteractor
{

    public function __construct() { }


    public function execute(CreateLotTenderServiceDTO $dto)
    {
        return $this->run($dto);
    }


    public function run(CreateLotTenderServiceDTO $dto)
    {

        $model = DB::transaction(function () use ($dto) {

            /**
             * @var LotTender
             */
            $lotTender = $this->createLotTender($dto->lotTenderVO);

        });

        return $model;

    }

    private function createLotTender(LotTenderVO $vo) : LotTender
    {
        return CreateLotTenderAction::make($vo);
    }

    public function сreateAgreementDocumentTender(AgreementDocumentTenderVO $vo) : AgreementDocumentTender
    {
        return CreateAgreementDocumentTenderAction::make($vo);
    }

    public function createApplicationDocumentTender(ApplicationDocumentTenderVO $vo) : ApplicationDocumentTender
    {
        return CreateApplicationDocumentTenderAction::make($vo);
    }

    public function сreateSpecificalDatePeriod(SpecificalDatePeriodVO $vo) : SpecificalDatePeriod
    {
        return CreateSpecificalDatePeriodAction::make($vo);
    }

}
