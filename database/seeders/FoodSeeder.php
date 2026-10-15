<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $foods = [
            ['name' => 'Daging', 'category' => 'Protein', 'image' => 'daging.png'],
            ['name' => 'Susu', 'category' => 'Protein', 'image' => 'susu.png'],
            ['name' => 'Ikan', 'category' => 'Protein', 'image' => 'ikan.png'],
            ['name' => 'Telur', 'category' => 'Protein', 'image' => 'telur.png'],
            ['name' => 'Keju', 'category' => 'Protein', 'image' => 'keju.png'],
            ['name' => 'Yogurt', 'category' => 'Protein', 'image' => 'yogurt.png'],
            ['name' => 'Tempe', 'category' => 'Protein', 'image' => 'tempe.png'],
            ['name' => 'Tahu', 'category' => 'Protein', 'image' => 'tahu.png'],
            ['name' => 'Kacang Hijau', 'category' => 'Protein', 'image' => 'kacang_hijau.png'],
            ['name' => 'Wortel', 'category' => 'Vitamin A', 'image' => 'wortel.png'],
            ['name' => 'Tomat', 'category' => 'Vitamin A', 'image' => 'tomat.png'],
            ['name' => 'Bayam', 'category' => 'Vitamin A', 'image' => 'bayam.png'],
            ['name' => 'Labu', 'category' => 'Vitamin A', 'image' => 'labu.png'],
            ['name' => 'Ubi Jalar', 'category' => 'Vitamin A', 'image' => 'ubi_jalar.png'],
            ['name' => 'Jeruk', 'category' => 'Vitamin C', 'image' => 'jeruk.png'],
            ['name' => 'Stroberi', 'category' => 'Vitamin C', 'image' => 'stroberi.png'],
            ['name' => 'Pepaya', 'category' => 'Vitamin C', 'image' => 'pepaya.png'],
            ['name' => 'Mangga', 'category' => 'Vitamin C', 'image' => 'mangga.png'],
            ['name' => 'Kiwi', 'category' => 'Vitamin C', 'image' => 'kiwi.png'],
            ['name' => 'Jambu Biji', 'category' => 'Vitamin C', 'image' => 'jambu_biji.png'],
        ];

        foreach ($foods as $food) {
            DB::table('foods')->updateOrInsert(
                ['name' => $food['name']],
                ['category' => $food['category'], 'image' => $food['image']]
            );
        }
    }

}
