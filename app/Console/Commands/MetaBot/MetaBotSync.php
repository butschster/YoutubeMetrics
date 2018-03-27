<?php

namespace App\Console\Commands\MetaBot;

use App\Contracts\Services\MetaBot\Client;
use App\Entities\Channel;
use App\Jobs\Youtube\UpdateChannelInformation;
use App\User;
use Illuminate\Console\Command;

class MetaBotSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metabot:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Синхронизация акканутов ботов с MetaBot';

    /**
     * @param Client $client
     */
    public function handle(Client $client)
    {
        $botList = $client->list();

        $metabotUser = User::metabot();

        $botList->each(function ($data) use($metabotUser) {
            $this->updateChannel($data['id'], $metabotUser->id);
        });
    }

    /**
     * @param string $id
     * @param string $userId
     */
    protected function updateChannel(string $id, string $userId)
    {
        Channel::updateOrCreate([
            'id' => $id
        ], [
            'bot' => true,
            'moderated_by' => $userId
        ]);

        dispatch(new UpdateChannelInformation($id));
    }
}
