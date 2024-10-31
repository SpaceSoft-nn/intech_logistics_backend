<?php

namespace App\Modules\Address\Common\Tests\Feature;

use App\Modules\Address\Domain\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_factory_Address()
    {
        $address = Address::factory()->create();

        $this->assertNotNull($address);
    }

    public function test_create_factory_custom_Address()
    {

        $address = Address::factory()->create([
            'latitude' => '55.5904650',
            'longitude' => '37.6593260',
        ]);

        $this->assertNotNull($address);
    }
}
