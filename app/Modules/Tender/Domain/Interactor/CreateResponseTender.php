<?php

namespace App\Modules\Tender\Domain\Interactor;
use DB;

/**
 * Интерактор для создание LotTender - так же логика добавление файлов + адрессов к LotTender
 */
final class CreateLotTenderInteractor
{

    public function __construct(

    ) { }


    public function execute()
    {
        return $this->run();
    }


    public function run()
    {

        DB::transaction(function () {

        });

    }


}
