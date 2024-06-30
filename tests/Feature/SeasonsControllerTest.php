<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\Season;
use Laravel\Sanctum\Sanctum;
use App\Models\User;



class SeasonsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Crear un usuario y autenticarlo
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function testListSeasons()
    {
        Season::factory()->create();

        $response = $this->getJson('/api/seasons');

        $response->assertStatus(200);
    }


    public function testShowSeason()
    {
        $season = Season::factory()->create();

        $response = $this->getJson('/api/seasons/' . $season->id);

        $response->assertStatus(201);
    }


    public function testSeasonsNotFound()
    {
        $response = $this->getJson('/api/seasons/ada');

        $response->assertStatus(404);
    }


    public function testDeleteSeason()
    {
        $season = Season::factory()->create();

        $response = $this->deleteJson('/api/seasons/' . $season->id);

        $response->assertStatus(201);
    }

    public function testCreateSeason()
    {
        $response = $this->postJson('/api/seasons', [
            'year' => 2022,
        ]);

        $response->assertStatus(201);
    }

    public function testUpdateSeason()
    {
        $season = Season::factory()->create();

        $response = $this->patchJson('/api/seasons/' . $season->id, [
            'year' => 2022,
        ]);

        $response->assertStatus(201);
    }
}
