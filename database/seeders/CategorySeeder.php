<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['name' => 'Makanan', 'budget_limit' => 500000],
            ['name' => 'Transportasi', 'budget_limit' => 300000],
            ['name' => 'Hiburan', 'budget_limit' => 200000],
            ['name' => 'Pendidikan', 'budget_limit' => 400000],
            ['name' => 'Kesehatan', 'budget_limit' => 250000],
        ];

    foreach ($data as $d) {
        Category::create([
            'name' => $d['name'],
            'budget_limit' => $d['budget_limit'],
            'is_active' => true
            ]);
        }
    }
}
