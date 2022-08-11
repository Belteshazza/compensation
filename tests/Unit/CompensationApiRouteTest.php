<?php

namespace Tests\Unit;

use Tests\TestCase;

class CompensationApiRouteTest extends TestCase
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

    public function test_getSingle()
    {
        $response = $this->get('api/getSingle/{id}');
        $response->assertStatus(200);
    }

    public function test_average_per_role()
    {
        $response = $this->post('api/avgRole');
        $response->assertStatus(200);
    }

    public function test_sortDesc()
    {
        $response = $this->get('api/sortDesc');
        $response->assertStatus(200);
    }

    public function test_sortAsc()
    {
        $response = $this->get('api/sortAsc');
        $response->assertStatus(200);
    }

    public function test_get_all_Compensation_and_paginate()
    {
        $response = $this->get('api/getCompensation');
        $response->assertStatus(200);
    }
}
