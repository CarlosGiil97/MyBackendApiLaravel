<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MatchesTest extends TestCase
{

    public function test_example(): void
    {
        $this->assertTrue(true);
    }


    public function testCreateModel(): void
    {
        $match = new \App\Models\Matches();
        $this->assertInstanceOf(\App\Models\Matches::class, $match);
    }


    public function testFillable(): void
    {
        $match = new \App\Models\Matches();
        $this->assertEquals(['user_id', 'team_id_home', 'team_id_away', 'location', 'cc', 'date', 'season_id', 'score_home', 'score_away', 'winner_id', 'result', 'tournament_id'], $match->getFillable());
    }
}
