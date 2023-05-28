<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    protected $table= 'users';
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'mail',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    //relaciones
      public function playlists()
        {
            return $this->hasMany(Playlists::class);
        }
        public function favorites()
        {
            return $this->hasMany(Favorites::class);
        }



    /*
    **
     * The attributes that should be cast.
     *
     * @var array<string, string>
     *
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    */
}
