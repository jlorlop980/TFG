<?php

namespace Database\Seeders;

use App\Models\Genres;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genres = ['NoGenre','lofi','ambient', 'japanese', 'vaporwave', 'chillhop'];
        foreach ($genres as $genre) {
            Genres::create([
                'name' => $genre,
            ]);
        }
    }
}
