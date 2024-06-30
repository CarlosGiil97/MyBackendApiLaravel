<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class UserProfile extends Model
{
    use HasFactory;

    public $timestamps = true;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'country',
        'postcode',
        'date_of_birth',
        'hobbies',
        'skills'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
