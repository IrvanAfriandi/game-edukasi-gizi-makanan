<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    public function index()
    {
        $foods = [
            'Protein' => Food::where('category', 'Protein')->get(),
            'Vitamin A' => Food::where('category', 'Vitamin A')->get(),
            'Vitamin C' => Food::where('category', 'Vitamin C')->get(),
        ];

        return view('game.index', compact('foods'));
    }

    public function submitMenu(Request $request)
    {
        $validated = $request->validate([
            'selectedFoods' => ['required', 'array', 'size:4'],
            'selectedFoods.*' => ['required', 'integer', 'distinct', 'exists:foods,id'],
        ]);

        $score = 0;
        $categories = [
            'Protein' => ['Daging', 'Susu', 'Ikan', 'Telur', 'Kacang-kacangan'],
            'Vitamin A' => ['Wortel', 'Tomat', 'Sayuran Hijau', 'Labu', 'Bayam'],
            'Vitamin C' => ['Jeruk', 'Stroberi', 'Pepaya', 'Mangga', 'Kiwi']
        ];

        $lowScoreFoods = ['Permen', 'Keripik', 'Soda'];
        $specialCombinations = [
            'Daging-Susu' => 20,
            'Ikan-Wortel' => 21,
            'Susu-Bayam' => 22,
            'Daging-Wortel' => 23,
            'Telur-Stroberi' => 24,
            'Ikan-Tomat' => 25,
            'Susu-Jeruk' => 26,
            'Bayam-Kiwi' => 27,
            'Labu-Jeruk' =>28,
            'Daging-Wortel-Jeruk' => 30,
            'Telur-Mangga-Tomat' => 31,
            'Ikan-Bayam-Stroberi' => 32,
            'Susu-Pepaya-Wortel' => 33,
        ];

        $selectedFoods = Food::whereIn('id', $validated['selectedFoods'])->get();
        $selectedFoodNames = $selectedFoods->pluck('name')->toArray();

        $categoryCount = [];

        // Hitung skor awal dan jumlah item per kategori
        foreach ($selectedFoods as $food) {
            foreach ($categories as $category => $foodList) {
                if (in_array($food->name, $foodList)) {
                    $score += 21;

                    // Hitung jumlah makanan per kategori
                    if (!isset($categoryCount[$category])) {
                        $categoryCount[$category] = 0;
                    }
                    $categoryCount[$category]++;
                    break;
                }
            }

            if (in_array($food->name, $lowScoreFoods)) {
                $score -= 5;
            }
        }

        // Pengurangan skor jika kategori memiliki lebih dari 2 item
        foreach ($categoryCount as $category => $count) {
            if ($count > 2) {
                $score -= 10;
            }
        }

        // Tambahkan poin untuk kombinasi spesial
        foreach ($specialCombinations as $combination => $bonus) {
            $combinationArray = explode('-', $combination);
            $containsAll = true;
            foreach ($combinationArray as $item) {
                if (!in_array($item, $selectedFoodNames)) {
                    $containsAll = false;
                    break;
                }
            }

            if ($containsAll) {
                $score += $bonus;
                break;
            }
        }

        Log::info('Final Score:', ['score' => $score, 'categoryCount' => $categoryCount]);

        return response()->json([
            'score' => $score,
            'selectedFoods' => $selectedFoods
        ]);
    }

    public function info(Request $request)
    {
        $score = $request->query('score');
        $score = is_numeric($score) ? (int) $score : null;
        $selectedFoodIds = $request->query('selectedFoods', []);

        if (is_string($selectedFoodIds)) {
            $decodedIds = json_decode($selectedFoodIds, true);
            $selectedFoodIds = is_array($decodedIds) ? $decodedIds : [];
        }

        if (!is_array($selectedFoodIds)) {
            $selectedFoodIds = [];
        }

        $selectedFoodIds = collect($selectedFoodIds)
            ->flatten()
            ->filter(fn ($id) => filter_var($id, FILTER_VALIDATE_INT) !== false)
            ->unique()
            ->values();

        if ($selectedFoodIds->isEmpty()) {
            return view('game.informasi-makanan')->with(['score' => $score, 'selectedFoods' => []]);
        }

        $foods = Food::whereIn('id', $selectedFoodIds)->get();
        $selectedFoods = $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'image' => $food->image,
                'name' => $food->name,
                'category' => $food->category
            ];
        });

        return view('game.informasi-makanan', compact('score', 'selectedFoods'));
    }
}
