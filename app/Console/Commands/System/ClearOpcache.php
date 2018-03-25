<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;

class ClearOpcache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'opcache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Сброс содержимого кеша опкодов';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (opcache_reset()) {
            $this->info("Cодержимое кеша опкодов сброшено.");
            return;
        }

        $this->error("Cодержимое кеша опкодов не сброшено.");
    }
}
