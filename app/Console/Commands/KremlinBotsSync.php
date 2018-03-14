<?php

namespace App\Console\Commands;

use App\Entities\Bot;
use App\Services\KremlinBots\Client;
use Illuminate\Console\Command;

class KremlinBotsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kremlin-bots:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync kremlin bot list from repository';

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $botList = $client->list();

        $existsIds = Bot::pluck('id', 'id');

        $botList->filter(function ($data) use ($existsIds) {
            return !$existsIds->contains($data['id']);
        })->each(function ($data) {
            Bot::forceCreate([
                'id' => $data['id'],
                'created_at' => $data['date']
            ]);
        });
    }
}
