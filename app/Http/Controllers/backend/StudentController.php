<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class StudentController extends Controller
{
    public function studentLogin()
    {
        return view('frontend.studentLogin');
    }

    public function loginSubmit(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('student')->attempt($credentials)) {
            return redirect()->intended(route('student.dashboard'));
        }

        return back()->with('error', 'Invalid Email or Password');
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
        return redirect('/Student/login');
    }
}
