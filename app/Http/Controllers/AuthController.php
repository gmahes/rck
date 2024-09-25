<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        $attr = [
            'title' => 'Login',
        ];
        return view('login', $attr);
    }
}
