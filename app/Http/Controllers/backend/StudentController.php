<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LiveClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class StudentController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }


    public function dashboard()
    {
        $student = Auth::guard('student')->user();
        $courses = Course::where('id', $student->course_id)->get();
        return view('backend.student-panel.dashboard', compact('student', 'courses'));
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect('/student/login');
    }

    public function profile()
    {
        $student = Auth::guard('student')->user();
        return view('backend.student-panel.profile.profile', compact('student'));
    }

    public function profileEdit()
    {
        $student = Auth::guard('student')->user();
        return view('backend.student-panel.profile.edit', compact('student'));
    }

    public function profileUpdate(Request $request)
    {
        $student = Auth::guard('student')->user();

        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/images/students'), $imageName);

            $student->image = $imageName;
        }

        $student->save();

        return back()->with('success', 'Profile Updated Successfully');
    }

    public function passwordUpdate(Request $request)
    {

        $student = Auth::guard('student')->user();

        if (!Hash::check($request->current_password, $student->password)) {
            return back()->with('error', 'Current password incorrect');
        }

        if ($request->new_password != $request->confirm_password) {
            return back()->with('error', 'Password not matched');
        }

        $student->password = Hash::make($request->new_password);
        $student->save();

        return back()->with('success', 'Password Updated Successfully');
    }

   public function Course()
{
    $student = Auth::guard('student')->user();

    // Fetch course with teacher relation
    $course = \App\Models\Course::with('teacher')->find($student->course_id);
    $liveclass = LiveClass::first();

    return view('backend.student-panel.course.course', compact('student', 'course', 'liveclass'));
}
}
