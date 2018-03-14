<?php

namespace App\Console\Commands;

use App\Entities\Author;
use App\Entities\Bot;
use Illuminate\Console\Command;

class SyncBotsWithAuthors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authors:sync-with-bots';

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
        Bot::get()->each(function (Bot $bot) {

            Author::updateOrCreate(['id' => $bot->id], [
                'created_at' => $bot->created_at,
                'bot' => true,
                'deleted' => $bot->deleted
            ]);

        });
    }
}
