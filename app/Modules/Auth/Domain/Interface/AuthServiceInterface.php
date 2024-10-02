<?php

namespace App\Modules\Auth\Domain\Interface;

use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use Illuminate\Database\Eloquent\Model;

interface AuthServiceInterface
{
    public function getUserAuth() : ?Model;
    public function attemptUserAuth(BaseDTO $data) : ?array;
    public function logout() : bool;
    public function refresh() : ?array;
    public function loginUser(Model $model) : ?array;

}
