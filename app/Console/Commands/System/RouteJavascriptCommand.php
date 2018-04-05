<?php

namespace App\Console\Commands\System;

use App\Services\LocalesJavascriptGenerator;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class RouteJavascriptCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'route:javascript';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Javascript routes file';

    /**
     * @param LocalesJavascriptGenerator $generator
     * @return int
     */
    public function handle(LocalesJavascriptGenerator $generator)
    {
        $this->call('ziggy:generate', [
            'path' => 'web/plugins/Http/router/routes.js'
        ]);
    }
}