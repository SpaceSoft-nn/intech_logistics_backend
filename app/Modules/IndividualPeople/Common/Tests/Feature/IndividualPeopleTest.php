<?php

namespace App\Modules\IndividualPeople\Common\Tests\Feature;

use App\Modules\User\Domain\Models\User;
use Tests\TestCase;

class IndividualPeopleTest extends TestCase
{
    public function test_create_individual_people()
    {
        $user = User::factory()->make();

        dd($user);
    }
}
