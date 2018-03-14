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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $authors = Comment::raw(function($collection) {
            return $collection->aggregate([
                ['$group' => [
                    '_id' => '$author_id', 'count' => ['$sum' => 1]
                ]]
            ]);
        })->pluck('count', 'id');

        foreach ($authors as $author => $count) {
            Author::updateOrCreate(['id' => $author], [
                'id' => $author,
                'total_comments' => $count
            ]);
        }
    }
}
