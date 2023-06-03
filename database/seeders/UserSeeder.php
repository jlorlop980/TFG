<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //user normal
        User::create([
            'name' => 'jose',
            'mail' => 'test@test.es',
            'password' => bcrypt('12345678')
        ]);
        //user admin
        User::create([
            'name' => 'admin',
            'mail' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'is_admin' => 1
        ]);

    }
}
