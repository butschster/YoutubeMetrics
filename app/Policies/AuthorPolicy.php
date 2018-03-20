<?php

namespace App\Policies;

use App\Entities\Author;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Author $author
     * @return bool
     */
    public function report(User $user, Author $author): bool
    {
        return true;
    }

    /**
     * @param User $user
     * @param Author $author
     * @return bool
     */
    public function moderate(User $user, Author $author): bool
    {
        return true;
    }
}
