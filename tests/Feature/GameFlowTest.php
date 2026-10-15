<?php

namespace Tests\Feature;

use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
            ->assertSee('src/img/')
            ->assertSee('`${assetBase}/${image}`', false)
            ->assertSee('Daging');
    }

    public function test_game_page_loads_food_categories_with_one_database_query(): void
    {
        $this->seed();

        DB::connection()->enableQueryLog();
        DB::connection()->flushQueryLog();

        $this->get(route('game'))->assertOk();

        $foodQueries = collect(DB::connection()->getQueryLog())
            ->filter(fn (array $query) => preg_match('/\bfrom\s+[`"]?foods[`"]?/i', $query['query']) === 1)
            ->count();

        $this->assertSame(1, $foodQueries);
    }

    public function test_default_database_seeder_adds_the_game_foods(): void
    {
        $this->seed();
        $this->seed();

        $this->assertDatabaseHas('foods', [
            'name' => 'Daging',
            'category' => 'Protein',
            'image' => 'daging.png',
        ]);
        $this->assertDatabaseCount('foods', 20);
    }

    public function test_game_menu_includes_new_foods_with_a_friendly_image_placeholder(): void
    {
        $this->seed();

        $this->get(route('game'))
            ->assertOk()
            ->assertSee('9 pilihan')
            ->assertSee('Tempe')
            ->assertSee('Ubi Jalar')
            ->assertSee('Jambu Biji')
            ->assertSee('Gambar segera ditambahkan');
    }

    public function test_education_index_and_nutrient_pages_are_available(): void
    {
        $this->get(route('belajar'))
            ->assertOk()
            ->assertSee('Kalsium')
            ->assertSee('Serat')
            ->assertSee('Zat Besi')
            ->assertSee('Vitamin D');

        foreach (['protein', 'vitamin_a', 'vitamin_c', 'kalsium', 'serat', 'zat_besi', 'lemak_sehat', 'vitamin_d'] as $slug) {
            $this->get(route("edukasi.{$slug}"))
                ->assertOk()
                ->assertSee('Apa manfaatnya?')
                ->assertSee('Contoh makanan');
        }
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
            ->assertJsonPath('score', 100)
            ->assertJsonCount(4, 'selectedFoods');
    }

    public function test_result_explains_balanced_selection_and_category_diversity_bonus(): void
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

        $this->get(route('informasi-makanan', [
            'score' => 999,
            'selectedFoods' => json_encode($foods->pluck('id')->all()),
        ]))
            ->assertOk()
            ->assertSee('Skor kamu')
            ->assertSee('100')
            ->assertSee('bonus keragaman penuh')
            ->assertSee('Bonus keragaman kategori: +60')
            ->assertSee('Setiap pilihan memberi 10 poin')
            ->assertSee('Skor maksimal 100')
            ->assertDontSee('999');
    }

    public function test_result_encourages_more_categories_without_penalizing_repeated_categories(): void
    {
        $foods = collect([
            ['Ikan', 'Protein'],
            ['Keju', 'Protein'],
            ['Yogurt', 'Protein'],
            ['Tempe', 'Protein'],
        ])->map(fn (array $food) => Food::create([
            'name' => $food[0],
            'category' => $food[1],
            'image' => strtolower($food[0]).'.png',
        ]));

        $this->get(route('informasi-makanan', [
            'score' => 999,
            'selectedFoods' => json_encode($foods->pluck('id')->all()),
        ]))
            ->assertOk()
            ->assertSee('40')
            ->assertSee('Semua pilihanmu berasal dari kategori Protein')
            ->assertDontSee('Pengurang')
            ->assertDontSee('999');
    }

    public function test_result_requires_exactly_four_distinct_existing_food_ids(): void
    {
        $foods = collect(range(1, 5))->map(fn (int $number) => Food::create([
            'name' => "Food {$number}",
            'category' => 'Protein',
            'image' => "food-{$number}.png",
        ]));
        $ids = $foods->pluck('id')->all();

        foreach ([
            [],
            array_slice($ids, 0, 3),
            array_slice($ids, 0, 5),
            [$ids[0], $ids[0], $ids[1], $ids[2]],
            [$ids[0], $ids[1], $ids[2], 999],
            [$ids[0], $ids[1], $ids[2], 'invalid'],
        ] as $selectedFoods) {
            $this->get(route('informasi-makanan', [
                'selectedFoods' => json_encode($selectedFoods),
            ]))
                ->assertRedirect(route('game'));
        }

        $this->followingRedirects()
            ->get(route('informasi-makanan', [
                'selectedFoods' => json_encode(array_slice($ids, 0, 3)),
            ]))
            ->assertOk()
            ->assertSee('Hasil tidak valid');
    }

    public function test_score_gives_a_bonus_for_each_additional_category(): void
    {
        $foods = collect([
            ['Daging', 'Protein'],
            ['Susu', 'Protein'],
            ['Wortel', 'Vitamin A'],
            ['Tomat', 'Vitamin A'],
        ])->map(fn (array $food) => Food::create([
            'name' => $food[0],
            'category' => $food[1],
            'image' => strtolower($food[0]).'.png',
        ]));

        $this->get(route('informasi-makanan', [
            'selectedFoods' => json_encode($foods->pluck('id')->all()),
        ]))
            ->assertOk()
            ->assertSee('70')
            ->assertSee('Bonus keragaman kategori: +30')
            ->assertSee('kategori Vitamin C');
    }

    public function test_new_foods_are_scored_from_their_category(): void
    {
        $foods = collect([
            ['Ikan', 'Protein'],
            ['Keju', 'Protein'],
            ['Labu', 'Vitamin A'],
            ['Kiwi', 'Vitamin C'],
        ])->map(fn (array $food) => Food::create([
            'name' => $food[0],
            'category' => $food[1],
            'image' => strtolower($food[0]).'.png',
        ]));

        $this->postJson(route('submit.menu'), [
            'selectedFoods' => $foods->pluck('id')->all(),
        ])
            ->assertOk()
            ->assertJsonPath('score', 100)
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

        $ids = $foods->pluck('id')->all();

        $this->postJson(route('submit.menu'), [
            'selectedFoods' => [$ids[0], $ids[0], $ids[1], 999],
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['selectedFoods.1', 'selectedFoods.3']);
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
            ->assertRedirect(route('game'));
    }
}
