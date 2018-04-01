<?php

namespace App\Console\Commands\System;

use App\Services\LocalesJavascriptGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class LocalesJavascriptCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'locales:javascript';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Javascript locales file';

    /**
     * @param LocalesJavascriptGenerator $generator
     * @return int
     */
    public function handle(LocalesJavascriptGenerator $generator)
    {
        if ($generator->make($this->option('lang'))) {
            $this->info("Locales file created");

            return 0;
        }

        $this->error("Could not create locales file");

        return 1;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['lang', 'l', InputOption::VALUE_OPTIONAL, 'Current language.', config('app.locale')],
        ];
    }
}