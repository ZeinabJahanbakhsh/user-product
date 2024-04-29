<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends Controller
{

    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validated();

        $credentials   = $request->only('email', 'password');
        $user['token'] = \auth('api')->attempt($credentials);

        if (!$user['token']) {
            return response()->json([
                'message' => __('messages.Unauthorized'),
            ], ResponseAlias::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => __('messages.login_user_success'),
            'data'    => $user
        ], ResponseAlias::HTTP_OK);
    }



}
