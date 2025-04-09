<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Exception;

class AuthController extends Controller 
{

    use ApiResponseTrait;
    public function __construct(private AuthService $authService) {}

    
    // Register
    public function register(Request $request) 
    {
        try {
                $data = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:8'
                ]);
                
                $token = $this->authService->register($data);
                $user = $this->authService->userRepo->findByEmail($request->email);
                

                
                return $this->responseSuccess([
                    'token' => $token,
                    'user' => new UserResource($user)
                ], 'Registration successful');

        } catch (Exception $e) {

                return $this->responseError($e->errors(), 'Registration failed', 422);
        }
    }

    // Login
    public function login(Request $request) 
    {
        try {
                $data = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string'
                
                ]);
                $user = $this->authService->userRepo->findByEmail($request->email);
                $token = $this->authService->login($data);

                if (!$token) return $this->responseError(null, 'Invalid email or password', 401);

                return $this->responseSuccess([
                    'token' => $token,
                    'user' => new UserResource($user)
                ], 'login successful');

        } catch (Exception $e) {

                    return $this->responseError($e->errors(), 'Login failed', 422);
                    
        }
    }

    // Logout
    public function logout(Request $request) 
    {
        $this->authService->logout($request->user());
        return response()->json(['message' => 'Logged out']);
    }
}
