<?php

namespace App\Http\Controllers;

use App\Models\UserAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $attr = [
            'title' => 'Login',
        ];
        return view('login', $attr);
    }
    public function verify(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $userdetail = [
                'nik' => UserAuth::find(Auth::id())->userDetail->nik,
                'fullname' => UserAuth::find(Auth::id())->userDetail->fullname,
                'position' => UserAuth::find(Auth::id())->userDetail->position,
            ];
            $request->session()->put('userdetail', $userdetail);
            return redirect()->intended('/');
        }
        return back()->withErrors('Login Gagal!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to('/login');
    }
}
