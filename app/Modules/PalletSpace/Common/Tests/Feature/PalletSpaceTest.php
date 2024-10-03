<?php

namespace App\Modules\PalletSpace\Common\Tests\Feature;

use App\Modules\PalletSpace\Domain\Models\PalletSpace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PalletSpaceTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_factoty_palletSpace()
    {
        $model = PalletSpace::factory()->create();

        $this->assertNotNull($model);
    }
}
