<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TeamLeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamLeaderPanelController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();
        $studentCount = DB::table('students')->where('team_leader_id', $tl_data->id)->count();
        $totalEarnings = 0;
        return view('backend.team-leader-panel.dashboard', compact('tl_data', 'studentCount', 'totalEarnings'));
    }

    public function myStudents()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();

        $students = Student::with('course')->where('team_leader_id', $tl_data->id)->get();

        return view('backend.team-leader-panel.student.student-list', compact('students', 'tl_data'));
    }
}
