<?php

namespace Tests\Feature;
 
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
 
   public function test_unauthenticated_users_can_not_add_replies()
    {
        $this->withExceptionHandling()
        ->post('/threads/some-channel/1/replies', [])
        ->assertRedirect('/login');
    }
 
    public function test_an_authenticated_user_can_participate_in_forum_threads()
   {
    $this->withExceptionHandling()
    ->post('/threads/channel/1/replies', [])
    ->assertRedirect('/login');
    }

    function test_a_logged_in_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling()->signIn();
 
        $thread = make('App\Thread');
 
        $response = $this->post('/threads', $thread->toArray());
 
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->body)
            ->assertSee($thread->title);
    }
    public function test_a_reply_requires_a_body()
    {
        $this->signIn();
 
        $thread = create('App\Thread');
 
        $reply = make('App\Reply', ['body' => null]);
 
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
