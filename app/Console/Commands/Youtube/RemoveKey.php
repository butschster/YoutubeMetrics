<?php

namespace App\Console\Commands\Youtube;

use App\Entities\YoutubeKey;
use Illuminate\Console\Command;

class RemoveKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:remove-api-key {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление API ключа';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $key = $this->argument('key');

        if (!YoutubeKey::whereKey($key)->exists()) {
            return $this->error('API ключ не найден');
        }

        YoutubeKey::whereKey($key)->delete();
        $this->info('API ключ успешно удален.');
    }
}
