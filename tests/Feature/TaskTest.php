<?php

namespace Amirmahvari\Todo\Tests\Feature;

use Amirmahvari\Todo\Http\Resources\LabelResource;
use Amirmahvari\Todo\Http\Resources\TaskResource;
use Amirmahvari\Todo\Models\Task;
use App\User;
use Tests\TestCase;

class TaskTest extends TestCase
{
    public function loginAs(\Illuminate\Foundation\Auth\User $user)
    {
        return $this->actingAs($user)
            ->withHeaders([
                'Authorization'    => 'Bearer ' . $user->api_token,
                "Content-Type"     => "application/json",
                "X-Requested-With" => "XMLHttpRequest",
            ]);
    }

    /**
     * A basic feature test example.
     * test  create task
     * @return void
     */
    public function test_store_a_task()
    {
        $attributes = factory(Task::class)->make();
        $user = User::find($attributes->toArray()['user_id']);
        $response = $this->loginAs($user)
            ->json('POST', route('task.store'), $attributes->toArray())
            ->assertStatus(200);
        $this->assertEquals($response['data']['title'], $attributes->toArray()['title']);
    }

    /**
     * test validation title and description for create task
     */
    public function test_store_validation()
    {
        $this->loginAs(User::first())
            ->json('POST', route('task.store'))
            ->assertJsonValidationErrors(['title', 'description'])
            ->assertStatus(422);
    }

    /**
     * Check Users can only show their own
     */
    public function test_authorize_show_task()
    {
        $task = factory(Task::class)
            ->create()
            ->first();
        $this->loginAs(factory(User::class,1)->create()->first())
            ->json('GET',route('task.show', $task))
            ->assertStatus(403);
    }

    /**
     *  Users check view and data
     */
    public function test_show_task()
    {
        $task = factory(Task::class)
            ->create()
            ->first();
        $this->loginAs($task->user)
            ->get(route('task.show', $task))
            ->assertStatus(200)
            ->assertExactJson([
                "data"    => [
                    "id"          => $task->id,
                    "title"       => $task->title,
                    "description" => $task->description,
                    "status"      => $task->status,
                    "labels"      => LabelResource::collection($task->labels->loadCount('tasks')),
                ],
                "message" => "success",
                "status"  => 200,
                "success" => true
            ]);
    }

    /**
     * Check Users can only update their own
     */
    public function test_authorize_update_task()
    {
        $task = factory(Task::class, 1)
            ->create()
            ->first();
        $this->loginAs(factory(User::class,1)->create()->first())
            ->json('PATCH',route('task.update', $task))
            ->assertStatus(403);
    }

    /**
     * test validation title and description for update task
     */
    public function test_update_validation()
    {
        $task = factory(Task::class)
            ->create()
            ->first();
        $this->loginAs($task->user)
            ->json('PATCH',route('task.update', $task))
            ->assertJsonValidationErrors(['title', 'description'])
            ->assertStatus(422);
    }

    /**
     * test update task
     */
    public function test_update_a_task()
    {
        $task = factory(Task::class)
            ->create()
            ->first();
        $attribute = factory(Task::class)->make();
        $this->loginAs($task->user)
            ->json('PATCH',route('task.update', $task), $attribute->toArray())
            ->assertStatus(200);
        $this->assertDatabaseHas('tasks',
            Task::where('id', $task->id)
                ->first()
                ->toArray());
    }

    /**
     * test change status task
     */
    public function test_change_status_task()
    {
        $task = factory(Task::class,1)
            ->create()
            ->first();
        $this->loginAs($task->user)
            ->json('POST',route('task.status', $task),['status'=>'close'])
            ->assertStatus(200);
        $this->assertEquals(Task::find($task->id)->status,'close');
    }
}
