<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Omzet;

class OperasionalController extends Controller
{
    public function omzet(Request $request)
    {
        $attr = [
            'title' => 'Omzet',
            'fullname' => $request->session()->get('userdetail')['fullname'],
            'position' => $request->session()->get('userdetail')['position'],
            'omzets' => Omzet::all(),
        ];
        return view('operasional.omzet', $attr);
    }
    public function addOmzet(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'date' => 'required',
            'omzet' => 'required',
        ]);
        $omzet = new Omzet;
        $omzet->user_id = $request->user_id;
        $omzet->date = $request->date;
        $omzet->omzet = $request->omzet;
        $omzet->created_by = $request->session()->get('userdetail')['username'];
        $omzet->updated_by = $request->session()->get('userdetail')['username'];
        $omzet->save();
        return redirect()->route('omzet');
    }
}
