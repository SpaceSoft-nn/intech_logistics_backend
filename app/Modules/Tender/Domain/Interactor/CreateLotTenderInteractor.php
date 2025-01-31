<?php

namespace App\Modules\Tender\Domain\Interactor;
use App\Modules\Base\Error\BusinessException;
use App\Modules\Tender\App\Data\DTO\CreateLotTenderServiceDTO;
use App\Modules\Tender\App\Data\Enums\StatusTenderEnum;
use App\Modules\Tender\App\Data\ValueObject\AgreementDocumentTenderVO;
use App\Modules\Tender\App\Data\ValueObject\ApplicationDocumentTenderVO;
use App\Modules\Tender\App\Data\ValueObject\LotTenderVO;
use App\Modules\Tender\App\Data\ValueObject\SpecificalDatePeriodVO;
use App\Modules\Tender\App\Data\ValueObject\WeekPeriodVO;
use App\Modules\Tender\Domain\Actions\Document\CreateAgreementDocumentTenderAction;
use App\Modules\Tender\Domain\Actions\Document\CreateApplicationDocumentTenderAction;
use App\Modules\Tender\Domain\Actions\LotTender\CreateLotTenderAction;
use App\Modules\Tender\Domain\Actions\SpecificalDate\CreateSpecificalDatePeriodAction;
use App\Modules\Tender\Domain\Actions\SpecificalDate\CreateWeekPeriodAction;
use App\Modules\Tender\Domain\Models\AgreementDocumentTender;
use App\Modules\Tender\Domain\Models\ApplicationDocumentTender;
use App\Modules\Tender\Domain\Models\LotTender;
use App\Modules\Tender\Domain\Models\SpecificalDatePeriod;
use App\Modules\Tender\Domain\Services\DocumentFileService;
use Illuminate\Http\UploadedFile;
use DB;

/**
 * Интерактор для создание LotTender - так же логика добавление файлов + адрессов к LotTender
 */
final class CreateLotTenderInteractor
{

    public function __construct(
        private DocumentFileService $servFile,
    ) { }


    public function execute(CreateLotTenderServiceDTO $dto) : LotTender
    {
        return $this->run($dto);
    }


    public function run(CreateLotTenderServiceDTO $dto) : LotTender
    {

        //делаю проверку что должен быть указан только один из параметров
        if($dto->arrayWeekPeriod && $dto->arraySpecificalDatePeriod)
        {
            #TODO логика чу-чуть изменена в валидации, добавлен тип - можно оставить, но лучше в будущем сделать проверки на основе типов
            throw new BusinessException('указан week_period и specific_date_periods, нужно указывать либо только перидичность выполнения, либо только конкретные даты.' , 400);
        }

        /** @var LotTender */
        $model = DB::transaction(function () use ($dto) {

            /** Временно устанавливаем статус published при создании тендера, по стандарту он должен при создании добавлять в статус черновика
            * @var LotTenderVO
            */
            $lotTenderVO = $dto->lotTenderVO->setStatusTender(StatusTenderEnum::published);

            /**
            * @var LotTender
            */
            $lotTender = $this->createLotTender($lotTenderVO);

            //создаём запись AgreementDocumentTender и сохраняем файл в storage
            $this->createAndSaveAgreementDocumentTender($dto->agreementDocumentTenderFile, $lotTender->id);

            //создаём записи ApplicationDocumentTenderFile и сохраняем файлы
            if($dto->arrayApplicationDocumentTenderFiles) {
                foreach ($dto->arrayApplicationDocumentTenderFiles as $object) {
                    $this->createAndSaveApplicationDocumentTender($object, $lotTender->id);
                }
            }

            //Создаём записи дней недели при выборе тендера как периодность выполнения
            if($dto->arrayWeekPeriod)
            {
                foreach ($dto->arrayWeekPeriod as $enum) {
                    $this->createWeekPeriod(
                        WeekPeriodVO::make(
                            lot_tender_id: $lotTender->id,
                            value: $enum,
                        )
                    );
                }
            }

            //создаём записи SpecificalDatePeriodFile
            if($dto->arraySpecificalDatePeriod) {
                foreach ($dto->arraySpecificalDatePeriod as $object) {
                    $object['lot_tender_id'] = $lotTender->id;
                    $this->сreateSpecificalDatePeriod(
                        SpecificalDatePeriodVO::fromArrayToObject($object),
                    );
                }
            }

            return $lotTender;

        });

        return $model;

    }

    private function createLotTender(LotTenderVO $vo) : LotTender
    {
        return CreateLotTenderAction::make($vo);
    }


    /**
     * Сохранение в storage и создание информации в бд
     * @param UploadedFile $uploadedFile
     * @param string $lot_tender_id
     *
     * @return AgreementDocumentTender
     */
    public function createAndSaveAgreementDocumentTender(UploadedFile $uploadedFile, string $lot_tender_id) : AgreementDocumentTender
    {
        $path_save = $this->servFile->saveFile($uploadedFile, 'agreements', 'tender_documents');

        return $this->сreateAgreementDocumentTender(
            AgreementDocumentTenderVO::make(
                lot_tender_id: $lot_tender_id,
                path: $path_save,
            )
        );
    }

    private function сreateAgreementDocumentTender(AgreementDocumentTenderVO $vo) : AgreementDocumentTender
    {
        return CreateAgreementDocumentTenderAction::make($vo);
    }


    /**
     * Сохранение в storage и создание информации в бд
     * @param UploadedFile $uploadedFile
     * @param string $lot_tender_id
     *
     * @return ApplicationDocumentTender
     */
    private function createAndSaveApplicationDocumentTender(UploadedFile $uploadedFile, string $lot_tender_id) : ApplicationDocumentTender
    {
        $path_save = $this->servFile->saveFile($uploadedFile, 'applications', 'tender_documents');

        return $this->createApplicationDocumentTender(
            ApplicationDocumentTenderVO::make(
                lot_tender_id: $lot_tender_id,
                path: $path_save,
            )
        );
    }

    private function createApplicationDocumentTender(ApplicationDocumentTenderVO $vo) : ApplicationDocumentTender
    {
        return CreateApplicationDocumentTenderAction::make($vo);
    }

    private function сreateSpecificalDatePeriod(SpecificalDatePeriodVO $vo) : SpecificalDatePeriod
    {
        return CreateSpecificalDatePeriodAction::make($vo);
    }

    private function createWeekPeriod(WeekPeriodVO $vo)
    {
        return CreateWeekPeriodAction::make($vo);
    }

}
