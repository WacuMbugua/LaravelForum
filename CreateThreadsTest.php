<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**@test */

    
   // function test_guest_can_not_create_threads()
   // {
   //     $this->withoutExceptionHandling()->expectException('Illuminate\Auth\AuthenticationException');
 //
  //      $thread = make('App\Thread');
 
  //      $this->post('/threads', $thread->toArray());
  //  }


    function test_guest_can_not_create_threads()
    {
        $this->get('/threads/create')->assertRedirect('/login');
 
        $this->post('/threads')->assertRedirect('login');
    }

    function test_a_logged_in_user_can_create_new_threads()
    {
        $this->withoutExceptionHandling()->signIn();
 
        $thread = create('App\Thread');
 
        $response = $this->post('/threads', $thread->toArray());
        dd($response->headers->get('Location'));
    }

    function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }
 
    function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }
    
    public function publishThread($overrides = [])
    {
        $this->signIn();
 
        $thread = make('App\Thread', $overrides);
 
        return $this->post('/threads', $thread->toArray());
    }
    function test_a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();
 
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
 
        $this->publishThread(['channel_id' => 777])
            ->assertSessionHasErrors('channel_id');
    }
}