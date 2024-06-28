<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class TeamsTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Creación de modelo Teams
     */

    public function test_create_team_model()
    {
        $team = new \App\Models\Teams();
        $this->assertInstanceOf(\App\Models\Teams::class, $team);
    }


    /**
     * Test fillable
     * */

    public function test_fillable()
    {
        $team = new \App\Models\Teams();
        $this->assertEquals(['name', 'founded', 'logo', 'colors', 'description'], $team->getFillable());
    }
}
