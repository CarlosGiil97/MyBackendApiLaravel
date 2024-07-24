<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Matches;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'season_id',
        'image',
        'date_start',
        'date_end',
    ];

    public function matches()
    {
        return $this->hasMany(Matches::class);
    }
}
