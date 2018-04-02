<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Resources\User\PermissionsResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use KodiCMS\Assets\Contracts\MetaInterface;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Профиль авторизованного пользователя
     *
     * @param Request $request
     * @return UserResource
     */
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Права авторизованного пользователя
     *
     * @param Request $request
     * @return PermissionsResource
     */
    public function permissions(Request $request)
    {
        return new PermissionsResource($request->user());
    }
}
