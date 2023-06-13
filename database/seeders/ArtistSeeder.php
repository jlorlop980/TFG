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

        $artists = [
            [
                'name' => 'Unkown',
                'bio' => 'NoBio',
                'mail' => 'NoMail'
            ],
            [
                'name' => 'kupla',
                'bio' => 'NoBio',
                'mail' => 'test@test.com'
            ],
            [
                'name' => 'Color Parade',
                'bio' => 'NoBio',
                'mail' => 'prueba@prueba.es'
            ],
            [
                'name' => 'Musikal',
                'bio' => 'Nobio',
                'mail' => 'example@example.com'
            ],
            [
                'name' => 'Chillmore',
                'bio' => 'NoBio',
                'mail' => 'example@example.es'
            ],
            [
                'name' => 'Lofi_hour',
                'bio' => 'NoBio',
                'mail' => 'example@prueba.com'
            ]
        ];

        foreach ($artists as $artist) {
            Artists::create(
                [
                    'name' => $artist['name'],
                    'bio' => $artist['bio'],
                    'mail' => $artist['mail']
                ]
            );
        }
    }
}
