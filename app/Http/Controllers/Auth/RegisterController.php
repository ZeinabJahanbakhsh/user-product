<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;


class RegisterController extends Controller
{
    public function register(StoreUserRequest $request)
    {
        $credential = $request->validated();

        $user = User::forceCreate([
            'name'     => $credential['name'],
            'email'    => $credential['email'],
            'password' => Hash::make($credential['password']),
        ]);

        return response()->json([
            'message' => __('register_user_success'),
            'data'    => $user
        ], ResponseAlias::HTTP_CREATED);
    }


}
