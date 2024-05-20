<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Simon',
            'last_name' => 'Ebner',
            'email' => 'simon.ebner@liwest.at',
            'password' => bcrypt('password'),
            'profile_image' => null
        ]);

        User::create([
            'first_name' => 'Bejamin',
            'last_name' => 'Hofer',
            'email' => 'b.hofer@gmail.com.com',
            'password' => bcrypt('password'),
            'profile_image' => null
        ]);
    }
}
