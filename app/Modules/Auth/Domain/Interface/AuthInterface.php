<?php
namespace App\Modules\Auth\Domain\Interface;

use App\Modules\Auth\App\Data\DTO\BaseDTO;
use App\Modules\Auth\Common\Config\AuthConfig;
use Illuminate\Database\Eloquent\Model;

interface AuthInterface
{
    public function attemptUser(BaseDTO $data);
    public function loginUser(Model $model);
    public function user();
    public function logout();
    public function refresh();
    public function respondWithToken(string $token);
}
