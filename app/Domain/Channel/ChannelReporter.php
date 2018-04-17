<?php

namespace App\Domain\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Events\Channel\Reported;

class ChannelReporter
{
    /**
     * @var ChannelRepository
     */
    private $repository;

    /**
     * @var int
     */
    private $reporterId;

    /**
     * @param ChannelRepository $repository
     * @param int $reporterId
     */
    public function __construct(ChannelRepository $repository, int $reporterId)
    {
        $this->repository = $repository;
        $this->reporterId = $reporterId;
    }

    /**
     * @param string $channelId
     * @throws \App\Repositories\ChannelReportedException
     */
    public function sendReportToChannel(string $channelId): void
    {
        $this->repository->sendReport($channelId, $this->reporterId);
        event(new Reported($channelId));
    }
}