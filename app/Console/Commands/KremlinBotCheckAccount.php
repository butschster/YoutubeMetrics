<?php

namespace App\Console\Commands;

use App\Contracts\Services\Youtube\Client;
use App\Entities\Bot;
use Illuminate\Console\Command;

class KremlinBotCheckAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kremlin-bots:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check account status';

    /**
     * @param Client $client
     * @throws \Exception
     */
    public function handle(Client $client)
    {
        $bots = Bot::live()->orderBy('updated_at', 'asc')
            ->take(500)
            ->get()
            ->keyBy('id')
            ->chunk(50);

        foreach ($bots as $chunk) {
            $results = $client->getChannelsByIds($chunk->pluck('id')->toArray())->keyBy('id');

            foreach ($chunk as $bot) {
                $channel = $results->get($bot->id);

                if (!$channel) {
                    $bot->deleted = true;
                    $bot->save();
                } else {
                    $bot->touch();
                }
            }
        }
    }
}
