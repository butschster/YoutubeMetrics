<?php

namespace App\Events\Youtube;

use Illuminate\Foundation\Events\Dispatchable;

class DailyLimitExceeded
{
    use Dispatchable;

    /**
     * @var string
     */
    public $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }
}
