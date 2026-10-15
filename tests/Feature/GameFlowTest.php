<?php

namespace Tests\Feature;

use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GameFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_page_loads_with_available_food_choices(): void
    {
        Food::create(['name' => 'Daging', 'image' => 'daging.png', 'category' => 'Protein']);

        $this->get(route('game'))
            ->assertOk()
            ->assertSee('Pilih Makananmu')
            ->assertSee('Daging');
    }

    public function test_submitting_a_menu_returns_score_and_selected_foods(): void
    {
        $foods = collect([
            ['Daging', 'Protein'],
            ['Susu', 'Protein'],
            ['Wortel', 'Vitamin A'],
            ['Jeruk', 'Vitamin C'],
        ])->map(fn (array $food) => Food::create([
            'name' => $food[0],
            'category' => $food[1],
            'image' => strtolower($food[0]).'.png',
        ]));

        $this->postJson(route('submit.menu'), [
            'selectedFoods' => $foods->pluck('id')->all(),
        ])
            ->assertOk()
            ->assertJsonPath('score', 104)
            ->assertJsonCount(4, 'selectedFoods');
    }

    public function test_menu_submission_requires_four_distinct_existing_foods(): void
    {
        $foods = collect(range(1, 3))->map(fn (int $number) => Food::create([
            'name' => "Food {$number}",
            'category' => 'Protein',
            'image' => "food-{$number}.png",
        ]));

        $this->postJson(route('submit.menu'), [
            'selectedFoods' => $foods->pluck('id')->all(),
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('selectedFoods');
    }

    public function test_result_page_shows_selected_foods_from_id_list(): void
    {
        $food = Food::create([
            'name' => 'Wortel',
            'category' => 'Vitamin A',
            'image' => 'wortel.png',
        ]);

        $this->get(route('informasi-makanan', [
            'score' => 21,
            'selectedFoods' => json_encode([$food->id]),
        ]))
            ->assertOk()
            ->assertSee('Wortel')
            ->assertSee('21');
    }
}
