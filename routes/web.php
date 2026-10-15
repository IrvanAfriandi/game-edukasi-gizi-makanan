<?php

use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('home');
Route::view('/beranda', 'index')->name('beranda');
Route::view('/belajar', 'edukasi.index')->name('belajar');

Route::view('/protein', 'edukasi.protein')->name('edukasi.protein');
Route::view('/vitamin_a', 'edukasi.vitamin_a')->name('edukasi.vitamin-a');
Route::view('/vitamin_c', 'edukasi.vitamin_c')->name('edukasi.vitamin-c');

Route::get('/game', [GameController::class, 'index'])->name('game');
Route::post('/submit-menu', [GameController::class, 'submitMenu'])->name('submit.menu');
Route::get('/informasi-makanan', [GameController::class, 'info'])->name('informasi-makanan');
Route::redirect('/info', '/informasi-makanan')->name('info');
