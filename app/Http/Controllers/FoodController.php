<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all()->groupBy('category');
        return view('game.index', compact('foods'));
    }
    public function info(Request $request)
    {
        $score = $request->query('score');
        $selectedFoodIds = json_decode($request->query('selectedFoods', '[]'), true);

        if (empty($selectedFoodIds)) {
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
