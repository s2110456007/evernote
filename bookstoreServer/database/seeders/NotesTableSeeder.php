<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Note::create([
            'list_id' => 1,
            'title' => 'Wocheneinkauf',
            'description' => 'Obst, Gemüse, Alkohol, vieeelll Alkohol',
            'created_by' => 1
        ]);

        Note::create([
            'list_id' => 2,
            'title' => 'Monats Einkauf',
            'description' => '22 Wassermelonen, 15l Apfelsaft, 32kg Tortelini, ein Gefrierschrant und einen Regenschirm',
            'created_by' => 2
        ]);
    }
}
