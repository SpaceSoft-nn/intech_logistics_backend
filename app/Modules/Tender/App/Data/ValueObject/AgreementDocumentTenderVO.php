<?php

namespace App\Modules\Tender\App\Data\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use Arr;
use Illuminate\Contracts\Support\Arrayable;

final readonly class AgreementDocumentTenderVO implements Arrayable
{
    use FilterArrayTrait;

    public function __construct(
        public string $lot_tender_id,
        public string $path,
        public ?string $description,
    ) {}


    public static function make(

        string $lot_tender_id,
        string $path,
        ?string $description = null,

    ) : self {

        return new self(
            lot_tender_id: $lot_tender_id,
            path: $path,
            description: $description,
        );

    }


    public function toArray() : array
    {
        return [
            "lot_tender_id" => $this->lot_tender_id,
            "path" => $this->path,
            "description" => $this->description,
        ];
    }

    public static function fromArrayToObject(array $data): self
    {

        return self::make(
            lot_tender_id: Arr::get($data, 'lot_tender_id'),
            path: Arr::get($data, 'path'),
            description: Arr::get($data, 'description'),
        );

    }

}
