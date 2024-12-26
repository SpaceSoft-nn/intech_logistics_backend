<?php

namespace App\Modules\Tender\App\Data\DTO;

use App\Modules\Tender\App\Data\ValueObject\AgreementDocumentTenderVO;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;

final readonly class CreateLotTenderServiceDTO
{

    /**
     *  @var LotTenderVO $lotTenderVO
     *  @var AgreementDocumentTenderVO $agreementDocumentTenderVO
     *  @var ?ApplicationDocumentTenderVO[] $arrayApplicationDocumentTenderVO
     *  @var ?SpecificalDatePeriodVO[] $arraySpecificalDatePeriodVO
     */
    public function __construct(

        public LotTenderVO $lotTenderVO,
        public AgreementDocumentTenderVO $agreementDocumentTenderVO,
        public ?array $arrayApplicationDocumentTenderVO,
        public ?array $arraySpecificalDatePeriodVO,

    ) { }

    public static function make(

        LotTenderVO $lotTenderVO,
        AgreementDocumentTenderVO $agreementDocumentTenderVO,
        ?array $arrayApplicationDocumentTenderVO = null,
        ?array $arraySpecificalDatePeriodVO = null,

    ) : self {

        return new self(
            lotTenderVO: $lotTenderVO,
            agreementDocumentTenderVO: $agreementDocumentTenderVO,
            arrayApplicationDocumentTenderVO: $arrayApplicationDocumentTenderVO,
            arraySpecificalDatePeriodVO: $arraySpecificalDatePeriodVO,
        );

    }


    public function createDtoForArray(
        LotTenderVO $lotTenderVO,
        AgreementDocumentTenderVO $agreementDocumentTenderVO,
        ?array $arrayApplicationDocumentTenderVO,
        ?array $arraySpecificalDatePeriodVO,
    ) {

        $this->lotTenderVO = $lotTenderVO;
        $this->$agreementDocumentTenderVO = $$agreementDocumentTenderVO;

        $applicationDocumentTenderVO


    }

    private function createApplicationDocumentTenderVO()
    {
        
    }

}
