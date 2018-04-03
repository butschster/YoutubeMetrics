<?php

namespace App\Policies;

use App\Entities\Channel;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Channel $channel
     * @return bool
     */
    public function report(User $user, Channel $channel): bool
    {
        return !$channel->bot && !$channel->hasReportFrom($user);
    }
}
