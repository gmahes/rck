<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAuth;
use Illuminate\Support\Facades\Gate;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $attr = [
            'title' => 'Dashboard',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
        ];
        return view('dash', $attr);
    }
}
