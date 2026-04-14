<?php

namespace App\Http\Controllers\Institusi;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Institusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $institusi = $user->institusi;

        if (!$institusi) {
            // If user doesn't have institusi record, logout and redirect to register
            Auth::logout();
            return redirect()->route('register')->withErrors(['error' => 'Data profil Anda tidak lengkap. Silakan daftar ulang.']);
        }

        return view('institusi.dashboard', compact(
            'institusi'
        ));
    }
}
    