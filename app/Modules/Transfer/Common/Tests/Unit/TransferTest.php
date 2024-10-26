<?php

namespace App\Modules\Transfer\Common\Tests\Unit;

use App\Modules\Transfer\Domain\Models\Transfer;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_create_transfer_factory()
    {
        $model = Transfer::factory()->create();

        $this->assertNotNull($model);
    }
}

