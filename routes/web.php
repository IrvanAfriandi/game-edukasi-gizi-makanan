<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');
Route::view('/beranda', 'index')->name('beranda');
Route::get('/belajar', [EducationController::class, 'index'])->name('belajar');

foreach (['protein', 'vitamin_a', 'vitamin_c', 'kalsium', 'serat', 'zat_besi', 'lemak_sehat', 'vitamin_d'] as $slug) {
    Route::get("/{$slug}", [EducationController::class, 'show'])
        ->defaults('slug', $slug)
        ->name("edukasi.{$slug}");
}

Route::get('/game', [GameController::class, 'index'])->name('game');
Route::post('/submit-menu', [GameController::class, 'submitMenu'])->name('submit.menu');
Route::get('/informasi-makanan', [GameController::class, 'info'])->name('informasi-makanan');
Route::redirect('/info', '/informasi-makanan')->name('info');
