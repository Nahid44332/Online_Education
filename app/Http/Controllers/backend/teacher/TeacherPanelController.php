<?php

namespace App\Http\Controllers\backend\teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
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
    $subadmin = Auth::guard('subadmin')->user();

    // subadmins (id 6) -> teachers (subadmin_id 6, id 2)
    $teacherProfile = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

    if ($teacherProfile) {
        // teachers (id 2) -> courses (teacher_id 2)
        $course = \App\Models\Course::where('teacher_id', $teacherProfile->id)->first();
    } else {
        $course = null;
    }

    // শুধুমাত্র এই কোর্সের জন্য লাইভ ক্লাসগুলো আনুন
    $classes = $course ? LiveClass::where('course_id', $course->id)->latest()->get() : collect();

    return view('backend.teacher-panel.live-class', compact('classes', 'course'));
}

public function store(Request $request)
{
    $request->validate([
        'course_id'    => 'required|exists:courses,id', 
        'title'        => 'required',
        'meeting_link' => 'required|url',
    ]);

    // নির্দিষ্ট কোর্সের জন্য লিঙ্ক আপডেট বা তৈরি করুন
    LiveClass::updateOrCreate(
        ['course_id' => $request->course_id], 
        [
            'title'        => $request->title,
            'meeting_link' => $request->meeting_link,
            'status'       => 'active',
        ]
    );

    return back()->with('success', 'Live Class link updated successfully for this course!');
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
