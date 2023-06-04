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
            ["name"=>"eons", "id_artist"=>2, "id_genre"=>2, "url"=>"storage/NnkPspHA46.mp3","duration"=>"100"],
            ["name"=>"song1","id_artist"=>2, "id_genre"=>2, "url"=>"storage/NnkPspHA46.mp3","duration"=>"200"],
            ["name"=>"song2","id_artist"=>2, "id_genre"=>2, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song3","id_artist"=>3, "id_genre"=>3, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song4","id_artist"=>3, "id_genre"=>4, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song5","id_artist"=>2, "id_genre"=>3, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song6","id_artist"=>1, "id_genre"=>3, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song7","id_artist"=>2, "id_genre"=>3, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song8","id_artist"=>3, "id_genre"=>3, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song9","id_artist"=>2, "id_genre"=>4, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"],
            ["name"=>"song10","id_artist"=>3, "id_genre"=>2, "url"=>"storage/NnkPspHA46.mp3","duration"=>"320"]
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
