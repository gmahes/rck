<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperasionalController extends Controller
{
    public function omzet(Request $request)
    {
        $attr = [
            'title' => 'Omzet',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
        ];
        return view('operasional.omzet', $attr);
    }
}
