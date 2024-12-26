<?php

namespace App\Modules\Tender\App\Data\ValueObject\Response;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;
use Arr;

final readonly class AgreementTenderAcceptVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $agreement_tender_id,
        public bool $tender_creater_bool,
        public bool $contractor_bool,
    ) {}


    public static function make(

        string $agreement_tender_id,
        bool $tender_creater_bool,
        bool $contractor_bool,

    ) : self {

        return new self(
            agreement_tender_id: $agreement_tender_id,
            tender_creater_bool: $tender_creater_bool,
            contractor_bool: $contractor_bool,
        );

    }


    public function toArray() : array
    {
        return [
            "agreement_tender_id" => $this->agreement_tender_id,
            "tender_creater_bool" => $this->tender_creater_bool,
            "contractor_bool" => $this->contractor_bool,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            agreement_tender_id: Arr::get($data, 'agreement_tender_id'),
            tender_creater_bool: Arr::get($data, 'tender_creater_bool'),
            contractor_bool: Arr::get($data, 'contractor_bool'),
        );

    }

}
