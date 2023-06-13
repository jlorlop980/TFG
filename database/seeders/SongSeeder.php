<?php

namespace Database\Seeders;

use App\Models\Songs;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $songs = [
            ["name"=>"eons", "id_artist"=>2, "id_genre"=>2, "url"=>"storage/Eons_Kupla.mp3","duration"=>"207"],
            ["name"=>"A clearing","id_artist"=>3, "id_genre"=>2, "url"=>"storage/aclearing.mp3","duration"=>"147"],
            ["name"=>"Alone","id_artist"=>4, "id_genre"=>2, "url"=>"storage/alone.mp3","duration"=>"124"],
            ["name"=>"Sea Road","id_artist"=>5, "id_genre"=>3, "url"=>"storage/seaRoad.mp3","duration"=>"188"],
            ["name"=>"Sea Whisper","id_artist"=>5, "id_genre"=>4, "url"=>"storage/seaWhisper.mp3","duration"=>"151"],
            ["name"=>"Miss","id_artist"=>6, "id_genre"=>3, "url"=>"storage/miss.mp3","duration"=>"151"],
            ["name"=>"Chosen","id_artist"=>6, "id_genre"=>3, "url"=>"storage/chosen.mp3","duration"=>"207"],
        ];
        foreach($songs as $song){
            Songs::create([
                'name' => $song['name'],
                'id_artist' => $song['id_artist'],
                'id_genre' => $song['id_genre'],
                'url' => $song['url'],
                'duration' => $song['duration']
            ]);
        }
    }
}
