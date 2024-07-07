<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Models\Season;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use App\Models\Matches;
use App\Models\Teams;
use App\Models\Tournament;





class MatchesControllerTest extends TestCase
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

    public function testListMatches()
    {
        $team1 = Teams::factory()->create();
        $team2 = Teams::factory()->create();
        $season = Season::factory()->create();
        $tournament = Tournament::factory()->create([
            'season_id' => $season->id,
        ]);

        $match = new Matches();
        $match->user_id = $this->user->id;
        $match->team_id_home = $team1->id;
        $match->team_id_away = $team2->id;
        $match->tournament_id = $tournament->id;
        $match->location = 'Ubicacion test';
        $match->cc = 'ES';
        $match->date = '2024-06-30';
        $match->season_id = $season->id;

        $match->save();

        $response = $this->getJson('/api/matches');


        $response->assertStatus(200);
    }

    public function testListAMatch()
    {
        $team1 = Teams::factory()->create();
        $team2 = Teams::factory()->create();
        $season = Season::factory()->create();
        $tournament = Tournament::factory()->create([
            'season_id' => $season->id,
        ]);

        $match = new Matches();
        $match->user_id = $this->user->id;
        $match->team_id_home = $team1->id;
        $match->team_id_away = $team2->id;
        $match->tournament_id = $tournament->id;
        $match->location = 'Ubicacion test';
        $match->cc = 'ES';
        $match->date = '2024-06-30';
        $match->season_id = $season->id;

        $match->save();

        $response = $this->getJson('/api/matches/' . $match->id);


        $response->assertStatus(201);
    }

    public function testCreateMatch()
    {
        $team1 = Teams::factory()->create();
        $team2 = Teams::factory()->create();
        $season = Season::factory()->create();
        $tournament = Tournament::factory()->create([
            'season_id' => $season->id,
        ]);

        $data = [
            'user_id' => $this->user->id,
            'team_id_home' => $team1->id,
            'team_id_away' => $team2->id,
            'tournament_id' => $tournament->id,
            'location' => 'Ubicacion test',
            'cc' => 'ES',
            'date' => '2024-06-30',
            'season_id' => $season->id
        ];

        $response = $this->postJson('/api/matches', $data);

        $response->assertStatus(201);
        $response->assertJson([
            'msg' => 'Partido guardado con exito',
        ]);
    }


    public function testDuplicateHomeAway()
    {

        $team1 = Teams::factory()->create();
        $team2 = Teams::factory()->create();
        $season = Season::factory()->create();
        $tournament = Tournament::factory()->create([
            'season_id' => $season->id,
        ]);

        $data = [
            'user_id' => $this->user->id,
            'team_id_home' => $team1->id,
            'team_id_away' => $team1->id,
            'tournament_id' => $tournament->id,
            'location' => 'Ubicacion test',
            'cc' => 'ES',
            'date' => '2024-06-30',
            'season_id' => $season->id
        ];


        $response = $this->postJson('/api/matches', $data);


        $response->assertStatus(404);
        $response->assertJson([
            'msg' => 'El equipo local no puede ser el mismo que el equipo visitante',
            'data' => null
        ]);
    }

    public function testUpdateMatch()
    {

        $team1 = Teams::factory()->create();
        $team2 = Teams::factory()->create();
        $season = Season::factory()->create();
        $tournament = Tournament::factory()->create([
            'season_id' => $season->id,
        ]);

        $match = new Matches();
        $match->user_id = $this->user->id;
        $match->team_id_home = $team1->id;
        $match->team_id_away = $team2->id;
        $match->tournament_id = $tournament->id;
        $match->location = 'Ubicacion test';
        $match->cc = 'ES';
        $match->date = '2024-06-30';
        $match->season_id = $season->id;

        $match->save();

        $data = [
            'user_id' => $this->user->id,
            'team_id_home' => $team1->id,
            'team_id_away' => $team2->id,
            'tournament_id' => $tournament->id,
            'location' => 'Ubicacion test modificada',
            'cc' => 'ES',
            'date' => '2024-06-30',
            'season_id' => $season->id
        ];

        $response = $this->patchJson('/api/matches/' . $match->id, $data);

        $response->assertStatus(201);
        $response->assertJson([
            'msg' => 'Partido actualizado con exito',
        ]);
    }

    public function testDeleteMatch()
    {

        $team1 = Teams::factory()->create();
        $team2 = Teams::factory()->create();
        $season = Season::factory()->create();
        $tournament = Tournament::factory()->create([
            'season_id' => $season->id,
        ]);

        $match = new Matches();
        $match->user_id = $this->user->id;
        $match->team_id_home = $team1->id;
        $match->team_id_away = $team2->id;
        $match->tournament_id = $tournament->id;
        $match->location = 'Ubicacion test';
        $match->cc = 'ES';
        $match->date = '2024-06-30';
        $match->season_id = $season->id;

        $match->save();


        $response = $this->deleteJson('/api/matches/' . $match->id);


        $response->assertStatus(201);
    }
}
