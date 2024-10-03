<?php

namespace App\Modules\IndividualFace\Common\Tests\Feature;

use App\Modules\IndividualFace\Domain\Models\Driver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndividualFaceTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_factory_driver()
    {
        $model = Driver::factory()->create();

        $this->assertNotNull($model);
    }
}
