<?php

namespace Amirabbas8643\Todo\Tests\Feature;

use Amirabbas8643\Todo\Models\Task;
use App\User;
use Tests\TestCase;

class TaskTest extends TestCase
{

    /**
     * A basic feature test example.
     * test  create task
     * @return void
     */
    public function test_store_a_task()
    {
        $attributes = factory(Task::class)->make();
        $response = $this->actingAs(factory(User::class)
            ->create()
            ->first())
            ->post(route('task.store') , $attributes->toArray())
            ->assertStatus(200);
        $this->assertEquals($response['data']['title'] , $attributes->toArray()['title']);
    }

    /**
     * test validation title and description for create task
     */
    public function test_store_validation()
    {
        $this->actingAs(User::first())
            ->post(route('task.store'))
            ->assertSessionHasErrors(['title' , 'description'])
            ->assertStatus(302);
    }

    /**
     * Check Users can only edit their own
     */
    public function test_authorize_edit_task()
    {
        $task = factory(Task::class)
            ->create()
            ->first();
        $this->actingAs(User::first())
            ->get(route('task.edit' , $task))
            ->assertStatus(403);
    }

    /**
     *  Users check view and data
     */
    public function test_show_edit_task()
    {
        $task = factory(Task::class)
            ->create()
            ->first();
        $this->actingAs($task->user)
            ->get(route('task.edit' , $task))
            ->assertStatus(200)
            ->assertViewIs('task.edit')
            ->assertViewHasAll(['task' => $task]);
    }

    /**
     * Check Users can only update their own
     */
    public function test_authorize_update_task()
    {
        $task = factory(Task::class , 1)
            ->create()
            ->first();
        $this->actingAs(User::first())
            ->patch(route('task.update' , $task))
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
        $this->actingAs($task->user)
            ->withHeaders([
                'Authorization'    => 'Bearer ' . $task->user->api_token ,
                "Content-Type"     => "application/json" ,
                "X-Requested-With" => "XMLHttpRequest",
            ])
            ->patch(route('task.update' , $task))
            ->assertJsonValidationErrors(['title' , 'description'])
            ->assertStatus(302);
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
        $this->actingAs($task->user)
            ->patch(route('task.update' , $task) , $attribute->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('tasks' ,
            Task::where('id' , $task->id)
                ->first()
                ->toArray());
    }
}
