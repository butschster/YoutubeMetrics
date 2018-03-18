<?php

namespace App\Console\Commands;

use App\Entities\Author;
use App\Entities\Comment;
use Illuminate\Console\Command;

class CalculateAuthorComments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authors:calculate-comments';

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
        $authors = Comment::selectRaw('id, count(id) as count')->groupBy('channel_id')->pluck('count', 'id');

        foreach ($authors as $author => $count) {
            Author::updateOrCreate(['id' => $author], [
                'id' => $author,
                'total_comments' => $count
            ]);
        }
    }
}
