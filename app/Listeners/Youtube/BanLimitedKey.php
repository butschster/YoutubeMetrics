<?php

namespace App\Listeners\Youtube;

use App\Contracts\Services\Youtube\KeyManager;
use App\Events\Youtube\DailyLimitExceeded;

class BanLimitedKey
{
    /**
     * @var KeyManager
     */
    private $manager;

    /**
     * @param KeyManager $manager
     */
    public function __construct(KeyManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param DailyLimitExceeded $event
     */
    public function handle(DailyLimitExceeded $event)
    {
        $this->manager->ban($event->key);
    }
}
