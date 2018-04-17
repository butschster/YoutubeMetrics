<?php

namespace App\Policies;

use App\Entities\Channel;
use App\Repositories\ChannelRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChannelPolicy
{
    use HandlesAuthorization;
    /**
     * @var ChannelRepository
     */
    private $repository;

    /**
     * @param ChannelRepository $repository
     */
    public function __construct(ChannelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param User $user
     * @param Channel $channel
     * @return bool
     */
    public function report(User $user, Channel $channel): bool
    {
        return !$channel->bot && !$this->repository->hasReportFrom($channel->id, $user->id);
    }
}
