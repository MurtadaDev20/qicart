<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthService {

    

    public function __construct(public UserRepositoryInterface $userRepo) {}

    // Register
    public function register($data) {
        $data['password'] = bcrypt($data['password']);
        $user = $this->userRepo->create($data);
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function login($credentials) {
        $user = $this->userRepo->findByEmail($credentials['email']);
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return null;
        }
        return $user->createToken('auth_token')->plainTextToken;
    }

    //Logout
    public function logout($user) {
        $user->tokens()->delete();
    }
}
