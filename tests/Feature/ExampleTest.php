<?php

namespace Tests\Feature;

use Tests\MyTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends MyTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTestF()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
