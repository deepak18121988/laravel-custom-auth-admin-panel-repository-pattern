<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $repo;

    public function __construct(AuthRepository $repo)
    {
        $this->repo = $repo;
    }

    // Register user
    public function register($data)
    {
        return $this->repo->createUser($data);
    }

    // Login logic
    public function login($data)
    {
        $user = $this->repo->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return false;
        }

        Auth::login($user);

        return $user;
    }
}