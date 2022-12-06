<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Status;
use App\Models\Task;

class TaskFactoryTest extends TestCase
{
    /**
     * Test creating a new order.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();


        $this->seed();
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = Task::factory()
            ->raw();
        $response = $this->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $status = Status::where('name', 'regular')->first();

        $this->assertDatabaseHas('tasks', $data);
        $this->assertDatabaseHas('tasks', [
            'status_id' => $status->id,
        ]);
    }

    public function testUpdate()
    {
        $task = Task::factory()
            ->create();

        $status = Status::where('name', 'urgent')->first();

        $data = [
            'id' => $task->id,
            'status_id' => $status->id,
            'completed' => true,
        ];


        $response = $this->patch(route('tasks.update', $task), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testDestroy()
    {

        $task = Task::factory()
            ->create();
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', $task->only('id'));
    }
}
