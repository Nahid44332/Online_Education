<?php

namespace App\Http\Controllers\backend\teacher;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('subadmin.role:teacher');
    }

    public function teacherDashboard()
    {
        $teacher = Auth::guard('subadmin')->user();
        return view('backend.teacher-panel.dashboard', compact('teacher'));
    }

    public function liveClass()
    {
        $classes = LiveClass::latest()->get();
        return view('backend.teacher-panel.live-class', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'meeting_link' => 'required|url',
        ]);

        // আগের সব লিঙ্ক মুছে ফেলে শুধু লেটেস্ট একটি রাখার জন্য
        LiveClass::truncate();

        LiveClass::create([
            'title' => $request->title,
            'meeting_link' => $request->meeting_link,
        ]);

        return back()->with('success', 'Live Class link updated successfully!');
    }

    public function destroy($id)
    {
        LiveClass::findOrFail($id)->delete();
        return back()->with('success', 'লিঙ্কটি ডিলিট করা হয়েছে।');
    }

    public function toggleStatus($id)
    {
        $class = LiveClass::findOrFail($id);

        // যদি active থাকে তবে expired হবে, আর না হয় active হবে
        $class->status = ($class->status == 'active') ? 'expired' : 'active';
        $class->save();

        return back()->with('success', 'Class status updated successfully!');
    }
}
