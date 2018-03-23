<?php

namespace App\Services\Youtube;

use App\Events\Youtube\DailyLimitExceeded;
use Exception;

class DailyLimitExceededException extends Exception
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @param string $key
     * @return DailyLimitExceededException
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        event(new DailyLimitExceeded($key));

        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }
}
