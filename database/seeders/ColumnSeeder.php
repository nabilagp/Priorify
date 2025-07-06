<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Column;

class ColumnSeeder extends Seeder
{
    public function run()
    {
        Column::insert([
            ['name' => 'To Do', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'In Progress', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Completed', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
