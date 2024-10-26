<?php

namespace App\Modules\Transfer\Common\Tests\Feature;

use App\Modules\Transfer\Domain\Models\Transfer;
use App\Modules\Transfer\Domain\Services\TransferService;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_create_transfer_service()
    {
        $serv = app(TransferService::class);

        $status = $serv->createTransfer(
            
        );

        dd($status)

    }
}

