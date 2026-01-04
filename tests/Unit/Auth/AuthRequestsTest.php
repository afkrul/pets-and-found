<?php

namespace Tests\Unit\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthRequestsTest extends TestCase
{
    public function test_register_request_rules()
    {
        $request = new RegisterRequest();
        $rules = $request->rules();
        $this->assertArrayHasKey('name', $rules);
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);
    }

    public function test_login_request_rules()
    {
        $request = new LoginRequest();
        $rules = $request->rules();
        $this->assertArrayHasKey('email', $rules);
        $this->assertArrayHasKey('password', $rules);
    }
}
