<?php

namespace Database\Seeders;

use App\Models\Favorites;
use Illuminate\Database\Seeder;

class FavoritesSeeder extends Seeder
{

    public function run()
    {
        $favorites =[
          ["id_users" => 1, "id_songs" => 1],
          ["id_users" => 1, "id_songs" => 3],
          ["id_users" => 1, "id_songs" => 2],
          ["id_users" => 1, "id_songs" => 4],
          ["id_users" => 1, "id_songs" => 5],
          ["id_users" => 1, "id_songs" => 6],
          ["id_users" => 1, "id_songs" => 7],
          ["id_users" => 1, "id_songs" => 8],
          ["id_users" => 1, "id_songs" => 9]
        ];
        foreach($favorites as $favorite){
            Favorites::create([
                'id_user' => $favorite['id_users'],
                'id_song' => $favorite['id_songs']
            ]);
        }
    }
}
