<?php

namespace App\Console\Commands\Comments;

use App\Entities\Channel;
use App\Entities\Comment;
use Illuminate\Console\Command;

class CalculateChannelComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:calculate-comments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Подсчет кол-ва комментариев для авторов';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $channels = Comment::selectRaw('channel_id, count(id) as count')
            ->groupBy('channel_id')
            ->pluck('count', 'channel_id');

        foreach ($channels as $channelId => $count) {
            Channel::updateOrCreate(['id' => $channelId], [
                'id' => $channelId,
                'total_comments' => $count
            ]);
        }

    }
}
