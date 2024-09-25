<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $attr = [
            'title' => 'Dashboard',
        ];
        return view('dash', $attr);
    }
}
