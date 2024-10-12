<?php

namespace App\Http\Controllers\API\Matrix;

use App\Http\Controllers\Controller;
use App\Modules\GAR\Common\Config\GARConfig;
use App\Modules\GAR\Domain\Services\GARService;
use Dadata\DadataClient;

class MatrixDistanceController extends Controller
{
    public function get(GARService $service)
    {

        $result = $service->run('Люберцы')->getFiasId();

        dd($result);
    }
}
