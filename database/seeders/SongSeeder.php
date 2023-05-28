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
            ["name"=>"eons", "id_artist"=>1, "id_genre"=>1, "url"=>"/public/song/eons"],
            ["name"=>"song2","id_artist"=>2,"id_genre"=>2, "url"=>"/public/song/song2"],
            ["name"=>"song3","id_artist"=>3, "id_genre"=>3, "url"=>"/public/song/song3"],
            ["name"=>"song4","id_artist"=>3, "id_genre"=>4, "url"=>"/public/song/song4"],
            ["name"=>"song5","id_artist"=>2, "id_genre"=>1, "url"=>"/public/song/song5"],
            ["name"=>"song6","id_artist"=>1, "id_genre"=>3, "url"=>"/public/song/song6"],
            ["name"=>"song7","id_artist"=>2, "id_genre"=>3, "url"=>"/public/song/song7"],
            ["name"=>"song8","id_artist"=>3, "id_genre"=>1, "url"=>"/public/song/song8"],
            ["name"=>"song9","id_artist"=>2, "id_genre"=>4, "url"=>"/public/song/song9"],
            ["name"=>"song10","id_artist"=>1, "id_genre"=>2, "url"=>"/public/song/song10"]
        ];
        foreach($songs as $song){
            Songs::create([
                'name' => $song['name'],
                'id_artist' => $song['id_artist'],
                'id_genre' => $song['id_genre'],
                'url' => $song['url'],
            ]);
        }
    }
}
