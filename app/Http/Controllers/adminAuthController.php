<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminAuthController extends Controller
{
    public function adminLogin()
    {
        return view('backend.Admin-login');
    }
    public function adminLogOut()
    {
        Auth::logout();

        return redirect('/admin/login');
    }
}
