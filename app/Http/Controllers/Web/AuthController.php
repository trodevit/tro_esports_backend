<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithdrawMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function registerPage()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'game_username' => ['required', 'string', 'max:255'],
            ]);

            User::create($data);

            return redirect()->route('login')->with('success', 'Registration Successful');
        }catch (\Exception $exception){
            return redirect()->back()->withErrors([$exception->getMessage()]);
        }
    }
    public function loginPage(Request $request)
    {
//        if ($request->cookie('admin_remember') && !session('is_admin')) {
//            session(['is_admin' => true]);
//            return redirect()->route('dashboard');
//        }
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->input('login');

        // Admin login check by email
        if (filter_var($loginInput, FILTER_VALIDATE_EMAIL) && $loginInput === env('ADMIN_EMAIL')) {
            if (!Hash::check($request->password, env('ADMIN_PASSWORD'))) {
                return back()->withErrors(['login' => 'Invalid credentials']);
            }
            session(['is_admin' => true]);
            return redirect()->route('dashboard');
        }

        // User login (phone or email in users table)
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = \App\Models\User::where($fieldType, $loginInput)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'Invalid credentials']);
        }

        Auth::login($user);
        return redirect()->route('home');
    }


    public function dashboard()
    {
        $pending = WithdrawMoney::where('payment_status', 'pending')
            ->latest()
            ->take(2) // limit to latest 10 if you don’t want to show all
            ->get();

        return view('dashboard',['pending'=>$pending]);
    }

    public function profile()
    {
        $money = WithdrawMoney::where('user_id', Auth::id())->get();
        return view('profile',['money'=>$money]);
    }

    public function logout(){
        session()->forget('is_admin');

        return redirect()->route('home');
    }

    public function userLogout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
