<?php

namespace App\Data\Auth;

use App\Http\Requests\Auth\RegisterRequest;

final class RegisterData
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        $v = $request->validated();

        return new self(
            $v['name'],
            $v['email'],
            $v['password'],
        );
    }
}
