<?php

namespace App\Console\Commands\System;

use App\User;
use Illuminate\Console\Command;

class GrantModerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:grant-moderator {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Предоставление прав модератора';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = User::whereEmail($this->argument('email'))->first();

        if (!$user) {
            $this->error('Пользователь не найден');
            return;
        }

        $user->update([
            'moderator' => true
        ]);

        $this->info('Права модератора выданы успешно.');
    }
}
