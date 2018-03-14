<?php

namespace App\Services\Youtube\Resources;

class Channel
{
    protected $data;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}