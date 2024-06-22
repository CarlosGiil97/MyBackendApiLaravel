<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Creación de modelo usuario
     */

    public function test_create_user_model()
    {
        $user = new \App\Models\User();
        $this->assertInstanceOf(\App\Models\User::class, $user);

        $this->assertEquals(['name', 'email', 'password'], $user->getFillable());
    }
}
