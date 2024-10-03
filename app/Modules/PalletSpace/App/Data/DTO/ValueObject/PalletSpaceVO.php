<?php

namespace App\Modules\PalletSpace\App\Data\DTO\ValueObject;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\PalletSpace\App\Data\Enums\TypeMaterialPalletSpaceEnum;
use App\Modules\PalletSpace\App\Data\Enums\TypeSizePalletSpaceEnum;
use Illuminate\Contracts\Support\Arrayable;

class PalletSpaceVO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(
        public TypeMaterialPalletSpaceEnum $type_material,
        public TypeSizePalletSpaceEnum $type_size,
        public string $size,
        public string $witght,
        public string $max_witght,
        public string $uuid_out,
        public string $manufacture,
        public ?string $description,
    ) {}

    public static function make(

        TypeMaterialPalletSpaceEnum $type_material,
        TypeSizePalletSpaceEnum $type_size,
        string $size,
        string $witght,
        string $max_witght,
        string $uuid_out,
        string $manufacture,
        ?string $description,

    ) : self {


        return new self(
            type_material: $type_material,
            type_size: $type_size,
            size: $size,
            witght: $witght,
            max_witght: $max_witght,
            uuid_out: $uuid_out,
            manufacture: $manufacture,
            description: $description,
        );

    }

    public function toArray() : array
    {
        return [
            "type_material" => $this->type_material->value,
            "type_size" => $this->type_size->value,
            "size" => $this->size,
            "witght" => $this->witght,
            "max_witght" => $this->max_witght,
            "uuid_out" => $this->uuid_out,
            "manufacture" => $this->manufacture,
            "description" => $this->description,
        ];
    }


}
