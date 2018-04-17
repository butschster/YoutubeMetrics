<?php

namespace App\Http\Controllers\Channel;

use App\Contracts\Repositories\ChannelRepository;
use App\Entities\Channel;
use App\Http\Controllers\Controller;
use App\Http\Resources\Video\VideoCollection;

class GetChannelVideos extends Controller
{
    /**
     * Список видео канала
     *
     * @param ChannelRepository $repository
     * @param Channel $channel
     * @return VideoCollection
     */
    public function __invoke(ChannelRepository $repository, Channel $channel): VideoCollection
    {
        return new VideoCollection(
            $repository->getChannelVideos($channel->id, 3)
        );
    }
}