<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\WithdrawMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginPage(Request $request)
    {
        if ($request->cookie('admin_remember') && !session('is_admin')) {
            session(['is_admin' => true]);
            return redirect()->route('dashboard');
        }
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($request->email !== env('ADMIN_EMAIL')) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }


        if (!Hash::check($request->password, env('ADMIN_PASSWORD'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        if ($request->has('remember')) {
            cookie()->queue('admin_remember', true, 60 * 24 * 30); // 30 days
        }

        session(['is_admin' => true]);

        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        $pending = WithdrawMoney::where('payment_status', 'pending')
            ->latest()
            ->take(2) // limit to latest 10 if you don’t want to show all
            ->get();

        return view('dashboard',['pending'=>$pending]);
    }

    public function logout(){
        session()->forget('is_admin');

        return redirect()->route('home');
    }
}
