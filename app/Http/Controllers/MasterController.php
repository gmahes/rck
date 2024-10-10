<?php

namespace App\Http\Controllers;

use App\Http\Requests\addEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function employees(Request $request)
    {
        $attr = [
            'title' => 'Employees',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
            'role_list' => ['administrator', 'user']
        ];
        return view('masters.employees', $attr);
    }
    public function addEmployee(addEmployee $request, Validator $validator)
    {
        dd($request->all());
        //     $validated = $validator::make($request->validated(), $request->rules(), $request->messages());
        //     if ($validated->fails()) {
        //         return redirect()->back()->withErrors($validated)->withInput();
        //     }
        //     return redirect()->route('employees');
    }
}
