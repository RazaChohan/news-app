<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        $this->withHeaders([
           'Accept' => 'application/json'
        ]);
        parent::setUp();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_news_list_without_token()
    {
        $response = $this->get(route('news-list'));

        $response->assertStatus(401);
    }

    /**
     * Test news list success
     */
    public function test_news_list_success()
    {
        News::factory(2)->create();

        $this
            ->actingAs(User::factory()->create())
            ->get(route('news-list'))
            ->assertStatus(200);
    }

    /**
     * Test news get success
     */
    public function test_news_get_success()
    {
        News::factory()->create();

        $this
            ->actingAs(User::factory()->create())
            ->get(route('news-get', 1))
            ->assertStatus(200)
            ->assertSee('id')
            ->assertSee('title')
            ->assertSee('content');
    }

    /**
     * Test news store success
     */
    public function test_news_store_success()
    {
        $data = ['title' => $this->faker->sentence(3), 'content' => $this->faker->paragraph(2)];

        $this->actingAs(User::factory()->create())->post(
            route('news-create'), $data
        )->assertStatus(201)->assertSee('id');
    }

    /**
     * Test news delete success
     */
    public function test_news_delete_success()
    {
        $user = User::factory()->create();
        $data = ['title' => $this->faker->sentence(3), 'content' => $this->faker->paragraph(2)];

        $response = $this->actingAs($user)->post(route('news-create'), $data)->getContent();

        $id = json_decode($response, true)['id'];

        $this->actingAs($user)->delete(route('news-delete', $id))->assertStatus(204);
    }

    /**
     * Test news delete success
     */
    public function test_news_update_success()
    {
        $user = User::factory()->create();
        $data = ['title' => $this->faker->sentence(3), 'content' => $this->faker->paragraph(2)];

        $response = $this->actingAs($user)->post(route('news-create'), $data)->getContent();

        $id = json_decode($response, true)['id'];

        $data['title'] = $data['title'] . ' ' . 'Updated';

        $this->actingAs($user)->put(route('news-update', $id), $data)->assertStatus(200);
    }

}
