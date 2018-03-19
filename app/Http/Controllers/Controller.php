<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use KodiCMS\Assets\Contracts\MetaInterface;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var MetaInterface
     */
    protected $meta;

    /**
     * @param MetaInterface $meta
     */
    public function __construct(MetaInterface $meta)
    {
        $this->meta = $meta;
    }

}
