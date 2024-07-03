<?php

namespace Tests\Unit;

use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/upload');

        $response->assertStatus(200);
    }
}
