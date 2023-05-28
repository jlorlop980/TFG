<?php

namespace Database\Seeders;

use App\Models\Artists;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artists = ["kupla", "glimpse","siloh"];
        foreach ($artists as $artist) {
            Artists::create([
                'name' => $artist,
            ]);
        }
    }
}
