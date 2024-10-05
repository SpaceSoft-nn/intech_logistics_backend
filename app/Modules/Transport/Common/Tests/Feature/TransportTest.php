<?php

namespace App\Modules\Transport\Common\Tests\Feature;

use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransportTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_factory_transport()
    {
        $transportModel = Transport::factory()->create();

        $this->assertNotNull($transportModel);
    }
}
