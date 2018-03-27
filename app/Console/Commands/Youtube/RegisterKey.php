<?php

namespace App\Console\Commands\Youtube;

use App\Entities\YoutubeKey;
use Illuminate\Console\Command;

class RegisterKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'youtube:register-api-key {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Регистрация нового API ключа';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $key = $this->argument('key');

        if (YoutubeKey::whereKey($key)->exists()) {
            return $this->error('Данный API ключ уже используется');
        }

        YoutubeKey::create([
            'key' => $key
        ]);

        $this->info('Ключ успешно добавлен.');
    }
}
