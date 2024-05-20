<?php

namespace Database\Seeders;

use App\Models\Evernotelist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvernotelistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Evernotelist::create([
            'name' => 'Obst',
            'created_by' => 1
        ]);

        Evernotelist::create([
            'name' => 'Wassermelonen',
            'created_by' => 2
        ]);
    }
}
