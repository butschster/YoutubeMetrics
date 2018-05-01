<?php

namespace App\Contracts\Services\MetaBot;

use Illuminate\Support\Collection;

interface Client
{
    /**
     * @return Collection
     */
    public function list(): Collection;
}