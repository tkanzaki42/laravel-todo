<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Todo;
use Faker\Factory;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Faker\Generator
     */
    private $faker;
    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }
    
    public function test_can_create_todo()
    {
        $data = [
            'task' => $this->faker->sentence,
        ];

        $this->post(route('todos.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
    }

    public function test_can_update_todo()
    {
        $todo = Todo::factory()->create();

        $data = [
            'id' => $todo->id,
            'task' => $this->faker->sentence,
        ];

        $this->put(route('todos.update', $todo->id), $data)
            ->assertStatus(204);
    }

    public function test_can_show_todo()
    {
        $todo = Todo::factory()->create();

        $this->get(route('todos.show', $todo->id))
            ->assertStatus(200);
    }

    public function test_can_destroy_todo()
    {
        $todo = Todo::factory()->create();

        $this->delete(route('todos.destroy', $todo->id))
            ->assertStatus(204);
    }

    public function test_can_list_todos()
    {
        $todos = collect(Todo::all())->map(function ($todo) {
            return $todo->only(['id', 'task']);
        });

        $this->get(route('todos.index'))
            ->assertStatus(200)
            ->assertJson($todos->toArray())
            ->assertJsonStructure([
                '*' => ['id', 'task'],
            ]);
    }
}
