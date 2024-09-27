<?php

namespace App\Modules\User\App\Data\Enums;

enum UserRoleEnum : string
{
    case admin = "admin";
    case manager = "manager";
    case observed = "observed";

}
