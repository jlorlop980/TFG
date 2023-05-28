<?php

namespace Database\Seeders;

use App\Models\Playlists;
use App\Models\Songs;
use Illuminate\Database\Seeder;

class SongPlaylistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //get the first 3 songs id
        $songs = Songs::all()->take(3);
        $playlist= Playlists::all()->first();
        foreach($songs as $song){
            $playlist->songs()->attach($song->id);
        }
    }
}
