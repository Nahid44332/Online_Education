<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $managers = Manager::with('subadmin')->orderBy('id', 'desc')->get();
        return view('backend.manager-panel.dashboard', compact('managers'));
    }
}
