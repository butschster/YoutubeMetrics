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
    protected $description = 'mark comments from bots as spam';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bots = Author::onlyBots()->live()->pluck('id');

        foreach ($bots as $bot) {
            Comment::where('author_id', $bot)->update([
                'spam' => true
            ]);
        }
    }
}
