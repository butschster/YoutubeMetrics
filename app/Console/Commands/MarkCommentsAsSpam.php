<?php

namespace App\Console\Commands;

use App\Entities\Author;
use App\Entities\Comment;
use Illuminate\Console\Command;

class MarkCommentsAsSpam extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comments:mark-spam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Пометка комментариев ботов как спам.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $authors = Author::onlyBots()->live()->get();

        foreach ($authors as $author) {
            $author->comments()->update(['is_spam' => true]);
        }
    }
}
