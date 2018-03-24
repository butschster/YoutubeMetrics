<?php

namespace App\Console\Commands\Youtube;

use App\Contracts\Services\Youtube\KeyManager;
use Illuminate\Console\Command;

class ShowActiveKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:keys-active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Список ключей, кторые используюся для получения данных';

    /**
     * @param KeyManager $manager
     */
    public function handle(KeyManager $manager)
    {
        $this->table(['Key'], collect($manager->keys())->map(function ($row) {
            return ['key' => $row];
        }));
    }
}
