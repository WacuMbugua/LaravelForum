<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ParticpateInForum extends TestCase
{
  use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
       //Given we have an autheniticated user
       $this->be($user = factory('App\User')->create());
        
        // and an existing thread
        $thread = factory('App\Thread')->create();

        //whena user adds a reply to the thread
        $reply = factory ('App\Reply')->create();
        $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());

      //then their reply should be visible on the page
      $this->get($thread->path())
        ->assertSee($reply->body);
    }
}
