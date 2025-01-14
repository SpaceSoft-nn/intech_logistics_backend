<?php

namespace App\Modules\Tender\App\Data\DTO;

use App\Modules\Base\Enums\WeekEnum;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use Illuminate\Http\UploadedFile;

final readonly class CreateLotTenderServiceDTO
{

    /**
    *  @var LotTenderVO $lotTenderVO
    *  @var UploadedFile $agreementDocumentTenderFile
    *  @var ?UploadedFile[] $arrayApplicationDocumentTenderFiles
    *  @var ?array $arraySpecificalDatePeriod
    *  @var ?WeekEnum[] $arrayWeekPeriod
    */
    public function __construct(

        public LotTenderVO $lotTenderVO,
        public UploadedFile $agreementDocumentTenderFile,
        public ?array $arrayApplicationDocumentTenderFiles,
        public ?array $arraySpecificalDatePeriod,
        public ?array $arrayWeekPeriod,

    ) { }

    /**
    *  @var LotTenderVO $lotTenderVO
    *  @var UploadedFile $agreementDocumentTenderFile
    *  @var ?array $arrayApplicationDocumentTenderFiles
    *  @var ?array $arraySpecificalDatePeriod
    *  @var ?WeekEnum[] $arrayWeekPeriod
    */
    public static function make(

        LotTenderVO $lotTenderVO,
        UploadedFile $agreementDocumentTenderFile,
        ?array $arrayApplicationDocumentTenderFiles = null,
        ?array $arraySpecificalDatePeriod = null,
        ?array $arrayWeekPeriod = null,

    ) : self {

        return new self(
            lotTenderVO: $lotTenderVO,
            agreementDocumentTenderFile: $agreementDocumentTenderFile,
            arrayApplicationDocumentTenderFiles: $arrayApplicationDocumentTenderFiles,
            arraySpecificalDatePeriod: $arraySpecificalDatePeriod,
            arrayWeekPeriod: $arrayWeekPeriod,
        );

    }

}
