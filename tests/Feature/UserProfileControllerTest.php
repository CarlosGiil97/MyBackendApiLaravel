<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;


class UserProfileControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_store(): void
    {

        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '1234567890',
        ];

        $response = $this->postJson('/api/profile', $data);

        $response->assertStatus(201)
            ->assertJson([
                'msg' => 'Información guardada con exito',
                'data' => [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '1234567890',
                ],
            ]);

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '1234567890',
        ]);
    }


    public function test_update(): void
    {

        $user = User::factory()->create();
        $profile = UserProfile::factory()->create([
            'user_id' => $user->id,
            'first_name' => 'OldName',
            'last_name' => 'OldLastName',
        ]);


        $this->actingAs($user);

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '1234567890',
        ];

        $response = $this->patchJson("/api/profile/{$profile->id}", $data);

        $response->assertStatus(201)
            ->assertJson([
                'msg' => 'Información actualizada con exito',
                'data' => [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'phone' => '1234567890',
                ],
            ]);

        $this->assertDatabaseHas('user_profiles', [
            'id' => $profile->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone' => '1234567890',
        ]);
    }


    public function test_show(): void
    {
        $user = User::factory()->create();
        $profile = UserProfile::factory()->create([
            'user_id' => $user->id,
            'first_name' => 'OldName',
            'last_name' => 'OldLastName',
        ]);

        $this->actingAs($user);

        $response = $this->getJson("/api/profile/{$profile->id}");

        $response->assertStatus(200)
            ->assertJson([
                'msg' => 'Información encontrada',
                'data' => [
                    'id' => $profile->id,
                    'user_id' => $user->id,
                    'first_name' => 'OldName',
                    'last_name' => 'OldLastName',
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ],
                ],
            ]);
    }
}
