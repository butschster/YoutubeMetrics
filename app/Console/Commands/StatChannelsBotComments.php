<?php

namespace App\Console\Commands;

use App\Entities\Channel;
use App\Entities\Comment;
use App\Entities\Video;
use Illuminate\Console\Command;

class StatChannelsBotComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:stat-bot-comments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сбор статистики комментариев ботов.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $videos = Comment::onlySpam()
            ->selectRaw('video_id, count(id) as count')
            ->groupBy('video_id')
            ->pluck('count', 'video_id');

        $channels = [];

        foreach ($videos as $id => $count) {
            $video = Video::find($id);

            if (!$video) {
                continue;
            }

            $channels[$video->channel_id][] = $count;
        }

        $channels = collect($channels)->map(function ($data) {
            return array_sum($data);
        });

        foreach ($channels as $channelId => $count) {
            $channel = Channel::find($channelId);
            $channel->bot_comments = $count;
            $channel->save();
        }
    }
}
