<?php

namespace App\Domain\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Events\Channel\Moderated;

class ChannelModerator
{
    /**
     * @var ChannelRepository
     */
    private $repository;
    /**
     * @var int
     */
    private $moderatorId;

    /**
     * @param ChannelRepository $repository
     * @param int $moderatorId
     */
    public function __construct(ChannelRepository $repository, int $moderatorId)
    {
        $this->repository = $repository;
        $this->moderatorId = $moderatorId;
    }

    /**
     * @param string $channelId
     * @param string $status
     * @throws ChannelStatusNotFound
     */
    public function setStatusForChannel(string $channelId, string $status)
    {
        $methodName = 'markAs'.ucfirst($status);
        if (!method_exists($this, $methodName)) {
            throw new ChannelStatusNotFound("Status {$status} not found");
        }

        $this->$methodName($channelId);

        event(new Moderated($channelId));
    }

    /**
     * @param string $channelId
     */
    public function markAsVerified(string $channelId): void
    {
        $this->repository->markAsVerified($channelId, $this->moderatorId);
    }

    /**
     * @param string $channelId
     */
    public function markAsBot(string $channelId): void
    {
        $this->repository->markAsBot($channelId, $this->moderatorId);
    }

    /**
     * @param string $channelId
     */
    public function markAsNormal(string $channelId): void
    {
        $this->repository->markAsNormal($channelId, $this->moderatorId);
    }
}