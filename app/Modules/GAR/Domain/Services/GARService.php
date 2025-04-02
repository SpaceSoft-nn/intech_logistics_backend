<?php

namespace App\Modules\GAR\Domain\Services;

use Dadata\DadataClient;
use Exception;
use Illuminate\Support\Collection;

class GARService
{

    private array $result;

    public function __construct(
        public DadataClient $client,
    ) { }

    /**
     * Вернуть fias_id из полученного GAR
     * @return string
     */
    public function getFiasId() : string
    {
        //Проверяем был ли вызван сначала run
        $this->checkEmptyResult();

        return $this->getFiasIdByAddress();
    }

    /**
     * Вернуть все данные GAR по адрессу
     * @return array
     */
    public function getAllInfo() : array
    {
        //Проверяем был ли вызван сначала run
        $this->checkEmptyResult();

        return $this->result;
    }

    //TODO Нужно возвращать DTO
    /**
     * Возвращает объект целиком, можно использовать билдер
     * @param string $Address адресс для поиска GAR
     *
     * @return self
     */
    public function run(string $Address) : self
    {
        $this->result = $this->getGarInfoByAddress($Address);
        return $this;
    }


    /**
     * Вернуть гар региона и его координаты
     * @param string $Address
     *
     * @return string
     */
    private function getFiasIdByAddress() : ?string
    {
        /**
        * @var Collection
        */
        $result = collect($this->result);

        //Проверяем был ли вызван сначала run
        $this->checkEmptyResult();

        try {

            return $result->get('fias_id', null);

        } catch (\Throwable $th) {

            //TODO Отлавливать ошибку более конкретно
            throw new Exception("Ошибка получение Fias Id City в GARService", 500);

        }

    }

    private function getGarInfoByAddress(string $address) : array
    {
        $result = $this->client->clean("address", $address);

        return $result;
    }

    private function checkEmptyResult()
    {
        if (empty($this->result)) {
            throw new Exception("Результат еще не установлен. Вызовите run() с адресом.");
        }
    }
}
