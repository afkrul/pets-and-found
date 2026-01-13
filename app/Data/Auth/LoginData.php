<?php

namespace App\Data\Auth;

use App\Http\Requests\Auth\LoginRequest;

final class LoginData
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        $v = $request->validated();

        return new self(
            $v['email'],
            $v['password'],
        );
    }
}
