<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserProfileTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Creación de modelo UserProfile
     */

    public function test_create_user_profile_model()
    {
        $userProfile = new \App\Models\UserProfile();
        $this->assertInstanceOf(\App\Models\UserProfile::class, $userProfile);

        $this->assertEquals(['first_name', 'last_name', 'phone', 'address', 'city', 'country', 'postcode', 'date_of_birth', 'hobbies', 'skills'], $userProfile->getFillable());
    }
}
