<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Malhal\Geographical\Geographical;

class Buyer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Geographical;

    protected static $kilometers = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ruc',
        'email',
        'city',
        'name',
        'phone',
        'dir',
        'ci',
        'latitude',
        'longitude',
        'biz',
        'doc',
        'ref',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'double',
        'longitude' => 'double',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function getCoords() {
        return coords($this->latitude, $this->longitude);
    }
}
