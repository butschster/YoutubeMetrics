<?php

namespace Tests\Unit\Youtube;

use App\Services\Youtube\Client;
use Closure;

class FakeClient extends Client
{
    /**
     * @var Closure
     */
    protected $return;

    public function __construct(){}

    /**
     * @param string $return
     */
    public function shouldReturn(Closure $return)
    {
        $this->return = $return;
    }

    public function api_get($url, $params)
    {
        $callback =  $this->return;

        return $callback($params);
    }
}