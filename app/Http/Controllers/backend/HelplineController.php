<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HelplineController extends Controller
{
    public function dashboard()
    {
        $helpline = Auth::guard('subadmin')->user();
        $helpline_data = DB::table('helplines')->where('subadmin_id', $helpline->id)->first();
        return view('backend.helpline-panel.dashboard', compact('helpline', 'helpline_data'));
    }
}
