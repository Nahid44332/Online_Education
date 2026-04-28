<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Counsellor;
use App\Models\Course;
use App\Models\Helpline;
use App\Models\Manager;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeamLeader;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $active_students   = Student::where('status', '1')->count();
        $inactive_students   = Student::where('status', '0')->count();
        $total_students    = Student::count();
        $total_teachers    = Teacher::count();
        $total_trainer  = Trainer::count();
        $total_teamleader  = TeamLeader::count();
        $total_counsellor  = Counsellor::count();
        $total_helpline = Helpline::count();
        $total_earnings = Payment::sum('amount');
        $total_course = Course::count();
        $today_reg   = Student::whereDate('created_at', Carbon::today())->count();
        $today_active = Student::where('status', '1')
                ->whereDate('updated_at', Carbon::today())
                ->count();
        return view('backend.manager-panel.dashboard', compact('managers',
        'active_students',
        'inactive_students',
        'total_students',
        'total_teachers',
        'total_trainer',
        'total_teamleader',
        'total_counsellor',
        'total_helpline',
        'total_earnings',
        'total_course',
        'today_reg',
        'today_active'
        ));
    }

    public function allStudent()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $students = Student::latest()->get();
        return view('backend.manager-panel.students.student',compact('managers', 'students'));
    }

    public function updatePoints(Request $request) {
    $student = Student::findOrFail($request->student_id);
    // আগের পয়েন্টের সাথে নতুন পয়েন্ট যোগ করা
    $student->points = $student->points + $request->points;
    $student->save();

    return back()->with('success', 'Points updated successfully!');
}
}
