<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'team_id_home',
        'team_id_away',
        'location',
        'cc',
        'date',
        'season_id',
        'score_home',
        'score_away',
        'winner_id',
        'result',
        'tournament_id'
    ];

    //relación con la tabla users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relación con la tabla teams home
    public function teamHome()
    {
        return $this->belongsTo(Teams::class, 'team_id_home');
    }

    //relación con la tabla teams away
    public function teamAway()
    {
        return $this->belongsTo(Teams::class, 'team_id_away');
    }

    //relación con la tabla seasons
    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    //relación con la tabla tournaments
    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
