<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Teams;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class TeamsControllerTest extends TestCase
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


    public function testListTeams()
    {
        Teams::factory()->count(3)->create();

        $response = $this->getJson('/api/teams');

        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }


    public function testShowTeam()
    {
        // Arrange
        $team = Teams::factory()->create();

        // Act
        $response = $this->getJson('/api/teams/' . $team->id);

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'msg' => 'Equipo obtenido con éxito',
            'data' => [
                'id' => $team->id,
                'name' => $team->name,
            ]
        ]);
    }

    public function testTeamsnotFound()
    {
        // Act
        $response = $this->getJson('/api/teams/999');

        // Assert
        $response->assertStatus(404);
        $response->assertJson([
            'msg' => 'Equipo no encontrado',
            'data' => null
        ]);
    }


    public function testCreateTeam()
    {
        // Arrange
        $data = [
            'name' => 'Team Name',
            'description' => 'Team Description',
            'founded' => 2023,
            'logo' => 'http://example.com/logo.png',
        ];

        // Act
        $response = $this->postJson('/api/teams', $data);

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'msg' => 'Información guardada con exito',
            'data' => [
                'name' => 'Team Name',
                'description' => 'Team Description',
                'founded' => 2023,
                'logo' => 'http://example.com/logo.png',
            ]
        ]);

        $this->assertDatabaseHas('teams', $data);
    }


    public function testUpdateTeam()
    {
        // Arrange
        $team = Teams::factory()->create();
        $data = [
            'name' => 'Updated Team Name',
            'description' => 'Updated Description',
            'founded' => 2024,
            'logo' => 'http://example.com/updated_logo.png',
            'colors' => 'Blue and White',
        ];

        // Act
        $response = $this->patchJson('/api/teams/' . $team->id, $data);


        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'msg' => 'Información actualizada con exito',
            'data' => [
                'name' => 'Updated Team Name',
                'description' => 'Updated Description',
                'founded' => 2024,
                'logo' => 'http://example.com/updated_logo.png',
                'colors' => 'Blue and White',
            ]
        ]);

        $this->assertDatabaseHas('teams', $data);
    }

    public function testDeleteTeam()
    {
        // Arrange
        $team = Teams::factory()->create();

        // Act
        $response = $this->deleteJson('/api/teams/' . $team->id);

        // Assert
        $response->assertStatus(201);
        $response->assertJson([
            'msg' => 'Equipo eliminado con exito',
            'data' => [
                'id' => $team->id,
                'name' => $team->name,
            ]
        ]);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
