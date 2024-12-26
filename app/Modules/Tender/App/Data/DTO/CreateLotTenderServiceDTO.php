<?php

namespace App\Modules\Tender\App\Data\DTO;

use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use Illuminate\Http\UploadedFile;

final readonly class CreateLotTenderServiceDTO
{

    /**
    *  @var LotTenderVO $lotTenderVO
    *  @var UploadedFile $agreementDocumentTenderFile
    *  @var ?UploadedFile[] $arrayApplicationDocumentTenderFiles
    *  @var ?array $arraySpecificalDatePeriod
    */
    public function __construct(

        public LotTenderVO $lotTenderVO,
        public UploadedFile $agreementDocumentTenderFile,
        public ?array $arrayApplicationDocumentTenderFiles,
        public ?array $arraySpecificalDatePeriod,

    ) { }

    /**
    *  @var LotTenderVO $lotTenderVO
    *  @var UploadedFile $agreementDocumentTenderFile
    *  @var ?array $arrayApplicationDocumentTenderFiles
    *  @var ?array $arraySpecificalDatePeriod
    */
    public static function make(

        LotTenderVO $lotTenderVO,
        UploadedFile $agreementDocumentTenderFile,
        ?array $arrayApplicationDocumentTenderFiles = null,
        ?array $arraySpecificalDatePeriod = null,

    ) : self {

        return new self(
            lotTenderVO: $lotTenderVO,
            agreementDocumentTenderFile: $agreementDocumentTenderFile,
            arrayApplicationDocumentTenderFiles: $arrayApplicationDocumentTenderFiles,
            arraySpecificalDatePeriod: $arraySpecificalDatePeriod,
        );

    }

    //  /**
    // *  @var LotTenderVO $lotTenderVO
    // *  @var ?array $agreementDocumentTenderFile
    // *  @var ?array[] $arrayApplicationDocumentTenderFiles
    // *  @var ?array[] $arraySpecificalDatePeriod
    // */
    // public static function createDtoForArray(
    //     LotTenderVO $lotTenderVO,
    //     ?array $agreementDocumentTenderFile,
    //     ?array $arrayApplicationDocumentTenderFiles,
    //     ?array $arraySpecificalDatePeriod,
    // ) : self {

    //     $lotTenderVO_virable = $lotTenderVO;
    //     $agreementDocumentTenderFile_virable = $$agreementDocumentTenderFile;

    //     $arrayApplicationDocumentTenderFiles_virable = self::createApplicationDocumentTenderVO($arrayApplicationDocumentTenderFiles);
    //     $arraySpecificalDatePeriod_virable = self::createSpecificalDatePeriodVO($arraySpecificalDatePeriod);

    //     return self::make(
    //         lotTenderVO: $lotTenderVO_virable,
    //         agreementDocumentTenderFile: $agreementDocumentTenderFile_virable,
    //         arrayApplicationDocumentTenderFile: $arrayApplicationDocumentTenderFiles_virable,
    //         arraySpecificalDatePeriod: $arraySpecificalDatePeriod_virable,
    //     );

    // }

    // private function createApplicationDocumentTenderVO(?array $data) : ?array
    // {
    //     $array = [];
    //     foreach ($data as $object) {
    //         $array[] = ApplicationDocumentTenderVO::fromArrayToObject($object);
    //     }

    //     return $array;
    // }

    // private function createApplicationDocumentTenderVO(?array $data) : ?array
    // {
    //     $array = [];
    //     foreach ($data as $object) {
    //         $array[] = ApplicationDocumentTenderVO::fromArrayToObject($object);
    //     }

    //     return $array;
    // }

    // private function createSpecificalDatePeriodVO(?array $data) : ?array
    // {
    //     $array = [];
    //     foreach ($data as $object) {
    //         $array[] = SpecificalDatePeriodVO::fromArrayToObject($object);
    //     }

    //     return $array;
    // }

}
