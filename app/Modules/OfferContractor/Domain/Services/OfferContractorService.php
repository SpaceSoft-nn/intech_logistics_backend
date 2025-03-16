<?php

namespace App\Modules\OfferContractor\Domain\Services;

use App\Modules\OfferContractor\Domain\Models\OfferContractor;
use App\Modules\OfferContractor\Domain\Models\OfferContractorCustomer;
use App\Modules\OfferContractor\App\Data\ValueObject\OfferContractorVO;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractor;
use App\Modules\OfferContractor\App\Data\DTO\OfferCotractorAddCustomerDTO;
use App\Modules\OfferContractor\App\Repositories\OfferCotractorRepository;
use App\Modules\OfferContractor\Domain\Models\AgreementOrderContractorAccept;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOfferDTO;
use App\Modules\OfferContractor\App\Data\DTO\OfferContractorAgreementOrderDTO;
use App\Modules\OfferContractor\Domain\Interactor\AgreementOfferOrderInteractor;
use App\Modules\OfferContractor\Domain\Interactor\AgreementOfferAcceptInteractor;
use App\Modules\OfferContractor\Domain\Interactor\ResponseOfferContractorInteractor;
use App\Modules\OfferContractor\Domain\Interactor\AgreementOfferContractorInteractor;

final class OfferContractorService
{

    public function __construct(
        private OfferCotractorRepository $offerCotractorRep,
    ) { }


    /**
     * @param OfferContractorVO $vo
     *
     * @return OfferContractor
     */
    public function createOfferContractor(OfferContractorVO $vo) : OfferContractor
    {
        /** @var OfferContractor */
        $offerContractor = $this->offerCotractorRep->create($vo);

        //обновляем что бы получить number из БД
        $offerContractor->refresh();

        return $offerContractor;
    }

    /**
     * Заказчик откликнулся на предложения перевозчика.
     * @param OfferCotractorAddCustomerDTO $dto
     *
     * @return OfferContractorCustomer
     */
    public function responseOfferContractor(OfferCotractorAddCustomerDTO $dto) : OfferContractorCustomer
    {
        return ResponseOfferContractorInteractor::execute($dto);
    }

    /**
     * Принимаем (оргиназацию заказчика) на исполнения предложения от перевозчика (то есть перевозчик выбрал заказ по отклику на предложения)
     * @param OfferContractorAgreementOfferDTO $dto
     *
     * @return AgreementOrderContractor
     */
    public function agreementOffer(OfferContractorAgreementOfferDTO $dto) : AgreementOrderContractor
    {
        return AgreementOfferContractorInteractor::execute($dto);
    }

    /**
     * Согласование с двух сторон.
     * @param AgreementOrderContractorAccept $agreementOrderContractorAccept
     *
     * @return AgreementOrderContractorAccept
     */
    public function agreementOfferAccept(AgreementOrderContractorAccept $agreementOrderContractorAccept) : AgreementOrderContractorAccept
    {
        #TODO При работе с ролями организовать подтврждения
        return AgreementOfferAcceptInteractor::execute($agreementOrderContractorAccept);
    }

    public function agreementOfferOrder(OfferContractorAgreementOrderDTO $dto)
    {
        return AgreementOfferOrderInteractor::execute($dto);
    }
}
