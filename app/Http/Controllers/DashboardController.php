<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAuth;
use Illuminate\Support\Facades\Gate;


class DashboardController extends Controller
{
    public function index()
    {
        $attr = [
            'title' => 'Dashboard',
            'fullname' => UserAuth::find(Auth::id())->userDetail->fullname,
            'position' => UserAuth::find(Auth::id())->userDetail->position,
        ];
        return view('dash', $attr);
    }
}
