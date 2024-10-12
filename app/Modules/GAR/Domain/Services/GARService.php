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

        return $this->getFiasIdByAdress();
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
     * @param string $adress адресс для поиска GAR
     *
     * @return self
     */
    public function run(string $adress) : self
    {
        $this->result = $this->getGarInfoByAdress($adress);
        return $this;
    }


    /**
     * Вернуть гар региона и его координаты
     * @param string $adress
     *
     * @return string
     */
    private function getFiasIdByAdress() : ?string
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

    private function getGarInfoByAdress(string $adress) : array
    {
        $result = $this->client->clean("address", $adress);

        return $result;
    }

    private function checkEmptyResult()
    {
        if (empty($this->result)) {
            throw new Exception("Результат еще не установлен. Вызовите run() с адресом.");
        }
    }
}
