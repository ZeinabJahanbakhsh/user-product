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
        $request->validated();

        $user = User::forceCreate([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->string('password')),
        ]);

        return response()->json([
            'message' => __('register_user_success'),
            'data'    => $user
        ], ResponseAlias::HTTP_CREATED);
    }


}
