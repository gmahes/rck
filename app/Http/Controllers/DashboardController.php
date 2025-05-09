<?php

namespace App\Http\Controllers;

use App\Models\UserAuth;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $attr = [
            'title' => 'Dashboard',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
        ];
        return view('dashboard.dash', $attr);
    }
    public function changePassword(Request $request, $username)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'oldpassword' => 'required|current_password',
                'newpassword' => 'required|min:8',
                'newpassword1' => 'required|same:newpassword'
            ],
            [
                'oldpassword.required' => 'Password lama belum diisi',
                'oldpassword.current_password' => 'Password lama salah',
                'newpassword.required' => 'Password baru belum diisi',
                'newpassword.min' => 'Password baru minimal 8 karakter',
                'newpassword1.required' => 'Password baru belum diisi',
                'newpassword1.same' => 'Password baru tidak sama'
            ],
        );
        if ($validator->fails()) {
            Alert::error('Gagal', $validator->errors()->first());
            return redirect()->back();
        }
        $validated = $validator->validated();
        UserAuth::where('username', $username)->update(['password' => bcrypt($validated['newpassword'])]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->to('/login');
    }
    public function dummy()
    {
        $attr = [
            'title' => 'Dummy',
            'fullname' => Auth::user()->userDetail->fullname,
            'position' => Auth::user()->userDetail->position,
        ];
        return view('non-operasional.upxlstable', $attr);
    }
}
