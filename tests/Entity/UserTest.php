<?php

use PHPUnit\Framework\TestCase;
use SturdyUmbrella\Entity\User;

class UserTest extends TestCase
{
    public function testAddingFriend()
    {
        $user = new User();
        $friend = new User();

        $user->addFriend($friend);

        $this->assertCount(1, $user->getFriends());
        $this->assertEquals($friend, $user->getFriends()->get(0));
    }

    public function testCannotAddMultipleIdenticalUserAsFriend()
    {
        $user = new User();
        $friend = new User();

        $user->addFriend($friend);
        $user->addFriend($friend);

        $this->assertCount(1, $user->getFriends());
    }

    public function testCannotAddSelfAsFriend()
    {
        $user = new User();
        $user->addFriend($user);

        $this->assertCount(0, $user->getFriends());
    }

    public function testAddingFriendUpdatesBothSides()
    {
        $user = new User();
        $friend = new User();

        $user->addFriend($friend);

        $this->assertEquals($user, $friend->getFriends()->get(0));
    }

    public function testRemoveFriend()
    {
        $user = new User();
        $friend = new User();

        $user->addFriend($friend);
        $user->removeFriend($friend);

        $this->assertCount(0, $user->getFriends());
    }

    public function testRemoveFriendUpdatesBothSides()
    {
        $user = new User();
        $friend = new User();

        $user->addFriend($friend);
        $user->removeFriend($friend);

        $this->assertCount(0, $friend->getFriends());
    }
}
