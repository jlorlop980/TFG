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
                'name' => 'NoArtist',
                'bio' => 'NoBio',
                'mail' => 'NoMail'
            ],
            [
                'name' => 'kupla',
                'bio' => 'Kupla is a Finnish producer and beatmaker. He has been making music for over 10 years and has released over 20 albums. His music is a mix of jazz, hip hop and lofi.',
                'mail' => 'test@test.com'
            ],
            [
                'name' => 'glimpse',
                'bio' => 'Glimpse is a Finnish producer and beatmaker. He has been making music for over 10 years and has released over 20 albums. His music is a mix of jazz, hip hop and lofi.',
                'mail' => 'prueba@prueba.es'
            ],
            [
                'name' => 'siloh',
                'bio' => 'Siloh is a Finnish producer and beatmaker. He has been making music for over 10 years and has released over 20 albums. His music is a mix of jazz, hip hop and lofi.',
                'mail' => 'example@example.com'
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
