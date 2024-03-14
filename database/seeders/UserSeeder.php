<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create([
            'name' => 'Gerardo Vera',
            'email' => 'geraveravela150b@gmail.com',
            'password' => bcrypt('password')
        ]);

        $user->assignRole('admin');

        User::factory(99)->create();
    }
}
