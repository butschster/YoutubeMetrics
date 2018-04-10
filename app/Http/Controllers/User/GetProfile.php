<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\PermissionsResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use KodiCMS\Assets\Contracts\MetaInterface;

class GetProfile extends Controller
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
    public function __invoke(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
