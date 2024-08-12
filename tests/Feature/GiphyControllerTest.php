<?php

namespace Tests\Feature;

use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GiphyControllerTest extends TestCase
{
    /** @test */
    public function it_requires_a_search_query_parameter()
    {
        $response = $this->getJson('/api/gifs', [
            'Authorization' => 'Bearer ' . Passport::actingAs(User::factory()->create())->token()
        ]);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function it_returns_gifs_when_search_query_is_provided() {
        $response = $this->getJson('/api/gifs?query=funny', [
            'Authorization' => 'Bearer ' . Passport::actingAs(User::factory()->create())->token()
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'title', 'url', 'images']
            ]
        ]);
    }

    /** @test */
    public function it_accepts_optional_limit_and_offset_parameters() {
        $response = $this->getJson('/api/gifs?query=funny&limit=5&offset=5', [
            'Authorization' => 'Bearer ' . Passport::actingAs(User::factory()->create())->token()
        ]);

        $response->assertStatus(200);

        $response->assertJsonCount(5, 'data');
    }

    /** @test */
    public function it_returns_a_gif_by_id_when_authenticated()
    {
        $gifId = 'xT4uQulxzV39haRFjG';

        $response = $this->getJson("/api/gifs/{$gifId}", [
            'Authorization' => 'Bearer ' . Passport::actingAs(User::factory()->create())->token()
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                'id', 'title', 'url', 'images'
            ]
        ]);
    }

    /** @test */
    public function it_returns_404_if_gif_not_found() {

        $nonExistentGifId = 999999;

        $response = $this->getJson("/api/gifs/{$nonExistentGifId}", [
            'Authorization' => 'Bearer ' . Passport::actingAs(User::factory()->create())->token()
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_saves_a_gif_as_favorite_when_authenticated() {

        $data = [
            'gif_id' => 2,
            'alias' => 'My Favorite GIF',
            'user_id' => 1,
        ];

        $response = $this->postJson('/api/gifs', $data, [
            'Authorization' => 'Bearer ' . Passport::actingAs(User::factory()->create())->token()
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('favorite_gifs', [
            'gif_id' => $data['gif_id'],
            'alias' => $data['alias'],
            'user_id' => $data['user_id'],
        ]);
    }

    /** @test */
    public function it_requires_all_fields_to_save_a_gif_as_favorite() {

        $response = $this->postJson('/api/gifs', [], [
            'Authorization' => 'Bearer ' . Passport::actingAs(User::factory()->create())->token()
        ]);

        $response->assertStatus(422);

        $response->assertJsonStructure([
            'error' => [
                'gif_id',
                'alias',
                'user_id'
            ]
        ]);
    }
}
