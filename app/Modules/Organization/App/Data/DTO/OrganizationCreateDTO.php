<?php

namespace App\Modules\Organization\App\Data\DTO;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use Illuminate\Contracts\Support\Arrayable;

class OrganizationCreateDTO extends BaseDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public OrganizationVO $organizationVO,

    ) { }

    public static function make(OrganizationVO $organizationVO) : self {

        return new self(
            organizationVO : $organizationVO,
        );
    }

    public function toArray(): array
    {
        return $this->organizationVO->toArray();
    }

}
