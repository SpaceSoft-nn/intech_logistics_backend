<?php

namespace App\Modules\Transfer\Common\Tests\Feature;

use App\Modules\OrderUnit\Domain\Models\AgreementOrder;
use App\Modules\Transfer\App\Data\DTO\Transfer\CreateTransferServiceDTO;
use App\Modules\Transfer\App\Data\DTO\Transfer\TransferDTO;
use App\Modules\Transfer\Domain\Services\TransferService;
use App\Modules\Transport\Domain\Models\Transport;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_create_transfer_service()
    {
        $serv = app(TransferService::class);

        $agrOrders = AgreementOrder::factory()->count(5)->create();

        $transport = Transport::factory()->create();

        $array = [];

        foreach ($agrOrders as  $agrOrder) {
            $array[] = $agrOrder->id;
        }

        $transfer = $serv->createTransfer(
            CreateTransferServiceDTO::make(
                main_order_id:  $agrOrders[0]->order->id,
                agreementOrder_id: $array,
                transferDTO: TransferDTO::make(
                    transport_id: $transport->id,
                    description: 'Test Description',
                ),
            )
        );

        $this->assertNotNull($transfer);
        $this->assertIsArray($transfer->agreements->toArray());
        $this->assertNotEmpty($transfer->agreements->toArray());

    }
}

