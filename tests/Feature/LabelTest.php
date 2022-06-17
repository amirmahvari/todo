<?php

namespace Amirmahvari\Todo\Tests\Feature;

use Amirmahvari\Todo\Http\Resources\LabelResource;
use Amirmahvari\Todo\Models\Label;
use Amirmahvari\Todo\Models\Task;
use App\User;
use Tests\TestCase;

class LabelTest extends TestCase
{
    public function loginAs()
    {
        $user = factory(User::class)->create()->first();
        return $this->actingAs($user)
            ->withHeaders([
                'Authorization'    => 'Bearer ' . $user->api_token,
                "Content-Type"     => "application/json",
                "X-Requested-With" => "XMLHttpRequest",
            ]);
    }

    /**
     * get list label
     * @return void
     */
    public function test_list_label()
    {
        $attributes = factory(Label::class)->make();
        $this->loginAs()
            ->json('POST', route('label.index'), $attributes->toArray())
            ->assertStatus(200)
            ->assertJsonCount(4);
    }


    /**
     * A basic feature test example.
     * test  create label
     * @return void
     */
    public function test_store_a_label()
    {
        $attributes = factory(Label::class)->make();
        $response = $this->loginAs()
            ->json('POST', route('label.store'), $attributes->toArray())
            ->assertStatus(200);
        $this->assertEquals($response['data']['label'], $attributes->toArray()['label']);
    }

    /**
     * test validation title and description for create label
     */
    public function test_store_validation()
    {
        $this->loginAs(User::first())
            ->json('POST', route('label.store'))
            ->assertJsonValidationErrors(['label'])
            ->assertStatus(422);
    }

    /**
     *  Users check view and data
     */
    public function test_show_show_label()
    {
        $label = factory(Label::class)
            ->create()
            ->first();
        $this->loginAs($label->user)
            ->get(route('label.show', $label))
            ->assertStatus(200)
            ->assertExactJson([
                "data"    => new LabelResource($label),
                "message" => "success",
                "status"  => 200,
                "success" => true
            ]);
    }

    /**
     * test validation label and description for update label
     */
    public function test_update_validation()
    {
        $label = factory(Label::class)
            ->create()
            ->first();
        $this->loginAs()
            ->json('PATCH', route('label.update', $label))
            ->assertJsonValidationErrors(['label'])
            ->assertStatus(422);
    }

    /**
     * test update label
     */
    public function test_update_a_label()
    {
        $label = factory(Label::class)
            ->create()
            ->first();
        $attribute = factory(Label::class)->make();
        $this->loginAs($label->user)
            ->json('PATCH', route('label.update', $label), $attribute->toArray())
            ->assertStatus(200);
        $this->assertDatabaseHas('labels',
            Label::where('id', $label->id)
                ->first()
                ->toArray());
    }

    /**
     * test delete label
     */
    public function test_delete_label()
    {
        $labels=Label::count();
        $label = factory(Label::class)
            ->create()
            ->first();
        $this->loginAs()
            ->json('DELETE', route('label.destroy', $label))
            ->assertStatus(200)
            ->assertJsonCount(4);
        $this->assertDatabaseCount('labels',$labels);
    }
}
