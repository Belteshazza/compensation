<?php

namespace Tests\Unit;
use App\Models\Compensation;
use App\Models\job;;
use Tests\TestCase;

class filterTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_filter()
    {
        $response = $this->get('api/filter');
        $response->assertStatus(200);
    }

   
}