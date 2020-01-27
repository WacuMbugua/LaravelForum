<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ThreadTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_has_replies()
    {
       $thread = factory('App\Thread')->create();
       
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    } 
    function test_a_thread_has_a_creator()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User', $thread->creator);
    }
}
