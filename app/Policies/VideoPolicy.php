<?php

namespace App\Policies;

use App\Entities\Video;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function clear_comments_cache(User $user, Video $video)
    {
        return true;
    }
}
