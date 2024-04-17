<?php

namespace App\Http\Controllers\Auth;

use App\Dtos\UserDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class RegisteredUserController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Display the registration view.
     */
    public function create(): InertiaResponse
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     */
    public function store(UserRequest $request): RedirectResponse
    {
        try {
            $userDto = UserDto::createFromRequest($request);
            $user = $this->userService->create($userDto);
            Auth::login($user);

            return to_route('dashboard');
        } catch (\Exception $e) {
            return redirect('register')->withErrors(['general' => $e->getMessage()])->withInput();
        }
    }
}
