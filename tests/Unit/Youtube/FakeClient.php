<?php

namespace Tests\Unit\Youtube;

use App\Services\Youtube\Client;

class FakeClient extends Client
{
    /**
     * @var string
     */
    protected $return;

    public function __construct(){}

    /**
     * @param string $return
     */
    public function shouldReturn(string $return)
    {
        $this->return = $return;
    }

    public function api_get($url, $params)
    {
        return $this->return;
    }
}