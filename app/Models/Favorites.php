<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    protected $table = 'favorites';
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_song'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function songs()
    {
        return $this->belongsTo(Songs::class, 'id_song');
    }

}
