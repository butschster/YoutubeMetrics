<?php

namespace Tests\Utility;

use App\User;

trait UserHelpers
{
    /**
     * @param User|null $user
     * @return User
     */
    public function signIn($user = null): User
    {
        $user = $user ?: $this->createUser();

        $this->be($user);

        return $user;
    }

    /**
     * Create a new user
     *
     * @param array $attributes
     * @param int $times
     * @return User
     */
    public function createUser(array $attributes = [], int $times = null)
    {
        return factory(User::class, $times)->create($attributes);
    }

    /**
     * Make a new user
     *
     * @param array $attributes
     * @param int $times
     * @return User
     */
    public function makeUser(array $attributes = [], int $times = null)
    {
        return factory(User::class, $times)->make($attributes);
    }
}