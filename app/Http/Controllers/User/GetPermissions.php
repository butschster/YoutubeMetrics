<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\PermissionsResource;
use Illuminate\Http\Request;

class GetPermissions extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     * @return PermissionsResource
     */
    public function __invoke(Request $request): PermissionsResource
    {
        return new PermissionsResource($request->user());
    }
}