<?php

namespace App\Modules\GAR\Common\Config;

use Exception;

class GARConfig
{

    public string $api_key_dadata;
    public string $secret_key_dadata;

    public function __construct()
    {

        try {

            $this->api_key_dadata = env('API_KEY_DADATA', null);
            $this->secret_key_dadata = env('SECRET_KEY_DADATA', null);

        } catch (\Throwable $th) {
            throw new Exception('Значение апи кеев для DADATA - не должна быть null', 500);
        }

    }

}
