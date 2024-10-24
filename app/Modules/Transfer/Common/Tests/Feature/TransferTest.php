<?php

namespace App\Modules\Transfer\Common\Tests\Feature;

use App\Modules\Transfer\Domain\Models\Transfer;
use Tests\TestCase;

class TransferTest extends TestCase
{
    public function test_create_transfer_factory()
    {
        $model = Transfer::factory()->create();

        dd($model);

        $this->assertNotNull($model);
    }
}

