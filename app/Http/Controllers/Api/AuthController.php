<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {


            $data = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|confirmed',
                'phone' => 'required|string|unique:users',
                'uid' => 'required|string|unique:users',
            ]);

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            return $this->errorResponse($user,'User registered successfully',201);
        }
        catch (\Exception $e) {
            return $this->errorResponse(null,'Something went wrong: '.$e->getMessage(), 500);
        }
        catch (ValidationException $e) {
            return $this->errorResponse(null,$e->errors(), 422);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

       $data = $request->only(['phone', 'password']);

        if (!$token = JWTAuth::attempt($data)) {
            return $this->errorResponse(null, 'Unauthorized', 401);
        }

        $user = Auth::user();

        return $this->successResponse(['user'=>$user, 'token'=>$token],'User logged in successfully',200);
    }

    public function profile()
    {
        $user = Auth::user();

        $this->authorize('view', $user);

        return $this->successResponse($user,'User logged in successfully',200);
    }

    public function logout(){
        Auth::logout();

        return $this->successResponse(null,'User logged out successfully',200);
    }
}
