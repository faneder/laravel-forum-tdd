<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_a_user_can_fetch_their_most_recent_reply()
    {
        $user = create('App\User');;

        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    public function test_a_user_can_determine_their_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals(asset('images/avatars/default.png'), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals(asset('avatars/me.jpg'), $user->avatar_path);
    }
}
