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
                'game_username' => 'required|string|unique:users',
            ]);

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            return $this->successResponse($user,'User registered successfully',201);
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

        if ($user->blocked == true) {
            abort(403, 'Your account has been suspended. Please contact support.');
        }

        return $this->successResponse(['user'=>$user, 'token'=>$token],'User logged in successfully',200);
    }

    public function profile()
    {
        $user = Auth::user();

        if ($user->blocked == true) {

            abort(403, 'Your account has been suspended. Please contact support.');
        }

        return $this->successResponse($user,'User logged in successfully',200);
    }

    public function phoneCheck(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string',
        ]);

        $exists = User::where('phone', $data['phone'])->first();

        if ($exists) {

            return $this->successResponse([$exists->name, $exists->email,$exists->phone], 'Matched', 200);
        }

        return $this->errorResponse(null, 'Not Matched', 400);
    }

    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|string|exists:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::where('phone',$data['phone'])->update(['password' => Hash::make($data['password'])]);

        return $this->successResponse(['user'=>$user], 'Password reset successfully', 200);
    }

    public function changePassword(Request $request)
    {
        try {
            $data = $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|confirmed',
            ]);

            if (Hash::check($data['current_password'], Auth::user()->getAuthPassword())){
                $user = Auth::user();
                $user->password  = Hash::make($data['new_password']);
                $user->save();

                Auth::logout();

                return $this->successResponse($user,'Password Changed successfully', 200);
            }
            else{
                return $this->errorResponse(null, 'Current password is incorrect', 400);
            }
        }
        catch (\Exception $e) {
            return $this->errorResponse(null,'Something went wrong: '.$e->getMessage(), 500);
        }

    }

    public function logout(){
        Auth::logout();

        return $this->successResponse(null,'User logged out successfully',200);
    }
}
