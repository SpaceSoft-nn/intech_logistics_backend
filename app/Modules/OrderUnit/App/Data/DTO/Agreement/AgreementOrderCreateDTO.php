<?php

namespace App\Modules\OrderUnit\App\Data\DTO\Agreement;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

final readonly class AgreementOrderCreateDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public string $order_unit_id,
        public string $organization_order_units_invoce_id,
        public ?string $organization_contractor_id,
    ) {}

    public static function make(
        string $order_unit_id,
        string $organization_order_units_invoce_id,
        ?string $organization_contractor_id = null,
    ) : self {


        return new self(
            order_unit_id: $order_unit_id,
            organization_order_units_invoce_id: $organization_order_units_invoce_id,
            organization_contractor_id: $organization_contractor_id,
        );

    }

    public function setOrgContractroId(string $orgContractroId) : self
    {
        return new self(
            order_unit_id: $this->order_unit_id,
            organization_order_units_invoce_id: $this->organization_order_units_invoce_id,
            organization_contractor_id: $orgContractroId,
        );
    }

    public function toArray() : array
    {
        return [
            "order_unit_id" => $this->order_unit_id,
            "organization_order_units_invoce_id" => $this->organization_order_units_invoce_id,
            "organization_contractor_id" => $this->organization_contractor_id,
        ];
    }
}
