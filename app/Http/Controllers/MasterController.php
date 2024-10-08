<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function employees(Request $request)
    {
        $attr = [
            'title' => 'Employees',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
        ];
        return view('masters.employees', $attr);
    }
}
