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
        return view('backend.manager-panel.dashboard', compact(
            'managers',
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

    public function allStudent($status = null)
{
    $user = Auth::guard('subadmin')->user();
    $managers = Manager::where('subadmin_id', $user->id)->first();

    // কুয়েরি শুরু করুন
    $query = Student::query();

    // যদি ইউআরএল এ স্ট্যাটাস থাকে, তবে ফিল্টার করুন
    if ($status == 'active') {
        $query->where('status', '1');
    } elseif ($status == 'inactive') {
        $query->where('status', '0');
    }

    $students = $query->latest()->get();

    return view('backend.manager-panel.students.student', compact('managers', 'students', 'status'));
}

    public function updatePoints(Request $request)
    {
        $student = Student::findOrFail($request->student_id);
        // আগের পয়েন্টের সাথে নতুন পয়েন্ট যোগ করা
        $student->points = $student->points + $request->points;
        $student->save();

        return back()->with('success', 'Points updated successfully!');
    }

   public function viewStudent($id)
    {
        $student = Student::with('course')->find($id);

        if (!$student) {
            return "<p class='text-danger'>Student not found!</p>";
        }

        // ছোট একটা সুন্দর টেবিল রিটার্ন করছি যা মোডালে শো করবে
        return "
        <div class='text-center mb-3'>
            <img src='" . asset('backend/images/students/' . $student->image) . "' style='width:100px; height:100px; border-radius:50%; object-fit:cover; border: 2px solid #ddd;'>
            <h4 class='mt-2'>{$student->name}</h4>
        </div>
        <table class='table table-bordered'>
            <tr><th class='bg-light'>Phone</th><td>{$student->phone}</td></tr>
            <tr><th class='bg-light'>Course</th><td>" . ($student->course->title ?? 'N/A') . "</td></tr>
            <tr><th class='bg-light'>Points</th><td><span class='badge badge-info'>{$student->points}</span></td></tr>
            <tr><th class='bg-light'>Status</th><td>" . ($student->status == 1 ? 'Active' : 'Inactive') . "</td></tr>
            <tr><th class='bg-light'>Joined Date</th><td>" . $student->created_at->format('d M Y') . "</td></tr>
        </table>";
    }
}
