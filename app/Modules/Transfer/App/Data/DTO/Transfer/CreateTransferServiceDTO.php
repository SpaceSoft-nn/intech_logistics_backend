<?php

namespace App\Modules\Transfer\App\Data\DTO\Transfer;

/**
 * @property string[] $orderUnit_id Массив строк, который содержит теги.
 * @property string $tags Массив строк, который содержит теги.
 * @property string $tags Массив строк, который содержит теги.
 */
class CreateTransferServiceDTO
{
    public function __construct(
        public ?array $orderUnit_id,
        public readonly string $main_order,
        public readonly string $agreementOrder_id,
    ) {}

    public static function make(
        ?array $orderUnit_id,
        string $main_order,
        string $agreementOrder_id,
    ) : self {

        return new self(
            orderUnit_id: $orderUnit_id,
            main_order: $main_order,
            agreementOrder_id: $agreementOrder_id,
        );

    }

}
