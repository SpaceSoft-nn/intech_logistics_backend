<?php

namespace App\Modules\OrderUnit\App\Data\DTO\Agreement;

use App\Modules\Base\Traits\FilterArrayTrait;
use Illuminate\Contracts\Support\Arrayable;

class AgreementOrderCreateDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public readonly string $order_unit_id,
        public readonly string $organization_order_units_invoce_id,
        public ?string $organization_transfer_id,
    ) {}

    public static function make(
        string $order_unit_id,
        string $organization_order_units_invoce_id,
        ?string $organization_transfer_id = null,
    ) : self {


        return new self(
            order_unit_id: $order_unit_id,
            organization_order_units_invoce_id: $organization_order_units_invoce_id,
            organization_transfer_id: $organization_transfer_id,
        );

    }

    public function toArray() : array
    {
        return [
            "order_unit_id" => $this->order_unit_id,
            "organization_order_units_invoce_id" => $this->organization_order_units_invoce_id,
            "organization_transfer_id" => $this->organization_transfer_id,
        ];
    }
}
