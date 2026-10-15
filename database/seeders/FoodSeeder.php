<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('foods')->insert([
            ['name' => 'Daging', 'category' => 'Protein', 'image' => 'daging.png'],
            ['name' => 'Susu', 'category' => 'Protein', 'image' => 'susu.png'],
            ['name' => 'Wortel', 'category' => 'Vitamin A', 'image' => 'wortel.png'],
            ['name' => 'Jeruk', 'category' => 'Vitamin C', 'image' => 'jeruk.png'],
            // Tambahkan makanan lainnya
        ]);
    }

}
