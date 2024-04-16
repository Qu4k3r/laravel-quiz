<?php

namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class UserService
{
    public function create(UserDto $userDto): User
    {
        $user = User::create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'password' => $userDto->getPassword(),
        ]);

        event(new Registered($user));
    }
}
