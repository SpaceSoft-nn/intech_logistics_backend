<?php

namespace App\Modules\Adress\Common\Tests\Feature;

use App\Modules\Adress\Domain\Models\Adress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdressTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_factory_adress()
    {
        $adress = Adress::factory()->create();


        $this->assertNotNull($adress);
    }

    public function test_create_factory_custom_adress()
    {

        $adress = Adress::factory()->create([
            'coordinates' => '-002, +002',
        ]);


        $this->assertNotNull($adress);
    }
}
