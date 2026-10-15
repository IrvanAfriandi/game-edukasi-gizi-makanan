<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function index()
    {
        $categories = ['Protein', 'Vitamin A', 'Vitamin C'];
        $foodsByCategory = Food::query()
            ->whereIn('category', $categories)
            ->orderBy('name')
            ->get()
            ->groupBy('category');
        $foods = collect($categories)
            ->mapWithKeys(fn (string $category) => [
                $category => $foodsByCategory->get($category, collect())->values(),
            ])
            ->all();

        return view('game.index', compact('foods'));
    }

    public function submitMenu(Request $request)
    {
        $validated = $request->validate([
            'selectedFoods' => ['required', 'array', 'size:4'],
            'selectedFoods.*' => ['required', 'integer', 'distinct', 'exists:foods,id'],
        ]);

        $selectedFoods = Food::whereIn('id', $validated['selectedFoods'])->get();
        $analysis = $this->analyzeMenu($selectedFoods);

        Log::info('Final Score:', [
            'score' => $analysis['score'],
            'categoryCounts' => $analysis['categoryCounts'],
        ]);

        return response()->json([
            'score' => $analysis['score'],
            'selectedFoods' => $selectedFoods
        ]);
    }

    public function info(Request $request)
    {
        $selectedFoodIds = $request->query('selectedFoods', []);

        if (is_string($selectedFoodIds)) {
            $decodedIds = json_decode($selectedFoodIds, true);
            $selectedFoodIds = is_array($decodedIds) ? $decodedIds : [];
        }

        if (!is_array($selectedFoodIds)) {
            $selectedFoodIds = [];
        }

        $selectedFoodIds = collect($selectedFoodIds)->flatten()->values();

        $normalizedFoodIds = $selectedFoodIds
            ->map(fn ($id) => filter_var($id, FILTER_VALIDATE_INT));

        if (
            $normalizedFoodIds->count() !== 4
            || ! $normalizedFoodIds->every(fn ($id) => $id !== false)
            || $normalizedFoodIds->unique()->count() !== 4
        ) {
            return redirect()->route('game')->with('error', 'Hasil tidak valid. Silakan pilih empat makanan untuk menghitung skor.');
        }

        $foods = Food::whereIn('id', $normalizedFoodIds)->get();

        if ($foods->count() !== 4) {
            return redirect()->route('game')->with('error', 'Sebagian makanan tidak ditemukan. Silakan pilih empat makanan kembali.');
        }

        $analysis = $this->analyzeMenu($foods);
        $selectedFoods = $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'image' => $food->image,
                'name' => $food->name,
                'category' => $food->category
            ];
        });
        $score = $analysis['score'];
        $feedback = $analysis['feedback'];
        $scoreBreakdown = $analysis['breakdown'];

        return view('game.informasi-makanan', compact('score', 'selectedFoods', 'feedback', 'scoreBreakdown'));
    }

    private function analyzeMenu($selectedFoods): array
    {
        $scoredCategories = ['Protein', 'Vitamin A', 'Vitamin C'];
        $categoryCounts = $selectedFoods
            ->whereIn('category', $scoredCategories)
            ->countBy('category')
            ->all();
        $foodPoints = $selectedFoods->count() * 10;
        $categoryCount = count($categoryCounts);
        $diversityBonus = max(0, $categoryCount - 1) * 30;
        $score = $foodPoints + $diversityBonus;
        $feedback = [];

        if ($categoryCount === count($scoredCategories)) {
            $feedback[] = 'Hebat! Pilihanmu mencakup Protein, Vitamin A, dan Vitamin C. Kamu mendapat bonus keragaman penuh.';
        } elseif ($categoryCount === 2) {
            $missingCategories = array_values(array_diff($scoredCategories, array_keys($categoryCounts)));
            $feedback[] = 'Pilihanmu mencakup dua kategori. Coba tambahkan makanan dari kategori '.$missingCategories[0].' agar pilihanmu lebih beragam.';
        } elseif ($categoryCount === 1) {
            $category = array_key_first($categoryCounts);
            $feedback[] = 'Semua pilihanmu berasal dari kategori '.$category.'. Coba pilih makanan dari kategori lain untuk mendapat bonus keragaman.';
        }

        $feedback[] = 'Skor ini hanya poin permainan. Kategori makanan memberi gambaran sederhana dan bukan penilaian lengkap nilai gizi atau kesehatan menu.';

        return [
            'score' => $score,
            'categoryCounts' => $categoryCounts,
            'feedback' => $feedback,
            'breakdown' => [
                'foodPoints' => $foodPoints,
                'diversityBonus' => $diversityBonus,
            ],
        ];
    }
}
