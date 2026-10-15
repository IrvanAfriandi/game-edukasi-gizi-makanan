<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk menggunakan DB facade

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('questions')->insert([
            [
                'question' => 'Jika aku ingin mataku sehat maka aku harus makan?',
                'image_option_1' => 'src/img/blog-1.png',
                'image_option_2' => 'src/img/blog-2.png',
                'correct_option' => 0 // Gambar wortel yang benar
            ],
            // Tambahkan pertanyaan lain di sini
        ]);
        
    }
}

