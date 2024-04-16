<?php

namespace App\Dtos;

use App\Http\Requests\UserRequest;

readonly class UserDto
{
    private function __construct(
        private string $name,
        private string $email,
        private string $hashedPassword
    )
    {
    }

    public static function createFromRequest(UserRequest $request): self
    {
        return new self(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->hashedPassword;
    }
}
