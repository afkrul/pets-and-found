<?php


namespace App\Http\Controllers;

use App\Actions\Auth\CreateToken;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Actions\Auth\Register;
use App\Actions\Auth\Login;
use App\Http\Resources\Auth\TokenResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(RegisterRequest $request, Register $register, CreateToken $createToken)
    {
        $user = $register($request->validated());
        $token = $createToken($user);
        return (new TokenResource(['access_token' => $token]))->response()->setStatusCode(201);
    }

    public function login(LoginRequest $request, Login $login, CreateToken $createToken)
    {
        $user = $login($request->validated());
        if (!$user) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $createToken($user);
        return new TokenResource(['access_token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
