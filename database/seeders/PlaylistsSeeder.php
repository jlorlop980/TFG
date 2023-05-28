<?php

namespace Database\Seeders;

use App\Models\Playlists;
use Illuminate\Database\Seeder;

class PlaylistsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $playlist = [
            ["name"=>"Kedabra", "id_users"=>1],
            ["name"=>"Sempra","id_users"=>1],
            ["name"=>"Harbor","id_users"=>1],
            ["name"=>"Yoru","id_users"=>1]
        ];

        foreach($playlist as $playlist){
            Playlists::create([
                'name' => $playlist['name'],
                'id_users' => $playlist['id_users']
            ]);
        }
    }
}
