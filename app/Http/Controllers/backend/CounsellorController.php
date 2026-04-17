<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CounsellorController extends Controller
{
    public function dashboard()
    {
        return view('backend.counsellor-panel.dashboard');
    }
}
