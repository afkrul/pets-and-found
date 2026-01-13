<?php

namespace App\Http\Controllers;

use App\Actions\Auth\CreateToken;
use App\Actions\Auth\Login;
use App\Actions\Auth\Register;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\TokenResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Register a new user and return a token.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request, Register $register, CreateToken $createToken)
    {
        $user = $register($request->dto());
        $token = $createToken($user);

        return (new TokenResource(['access_token' => $token]))->response()->setStatusCode(201);
    }

    /**
     * Login a user and return a token.
     *
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function login(LoginRequest $request, Login $login, CreateToken $createToken)
    {
        $user = $login($request->dto());
        if (! $user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $createToken($user);

        return new TokenResource(['access_token' => $token]);
    }

    /**
     * Revoke the current user's access token.
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
