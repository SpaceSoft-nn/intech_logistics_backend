<?php

namespace App\Modules\OrderUnit\Domain\Interactor\Status;


use App\Modules\OrderUnit\App\Repositories\OrderUnitRepository;
use DB;


class ParseEmailAndChangeTransportStatusInteractor
{

    public function __construct(
        public OrderUnitRepository $rep,
    ) {}

    public function execute(string $email)
    {
        return $this->run($email);
    }

    private function run(string $email)
    {

        DB::transaction(function () {

        });
    }

}
