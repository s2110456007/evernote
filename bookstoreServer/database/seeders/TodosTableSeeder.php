<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Todo::create([
            'note_id' => 1,
            'title' => 'Frühstück',
            'description' => 'Brot, Milch, Butter',
            'due_date' => now()->addDays(2),
            'created_by' => 1
        ]);

        Todo::create([
            'note_id' => 2,
            'title' => 'Mittagessen',
            'description' => 'Kaufe Nudeln und Pesto',
            'due_date' => now()->addDays(2),
            'created_by' => 2
        ]);
    }
}
