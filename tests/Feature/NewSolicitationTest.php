<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewSolicitationTest extends TestCase
{
    /**
     * @test
     */
    public function new_solicitation_response()
    {
        $response = $this->get('/new_solicitation');

        $response->assertStatus(404);
    }
}
