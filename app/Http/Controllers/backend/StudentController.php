<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Helpline;
use App\Models\LiveClass;
use App\Models\Settings;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    $my_tl = DB::table('team_leaders')->where('id', $student->team_leader_id)->first();
    $gifts = DB::table('transactions')
                ->where('description', 'LIKE', '%' . $student->name . '%')
                ->where('type', 'debit')
                ->orderBy('created_at', 'desc')
                ->get();
    $my_trainer = DB::table('trainers')->where('id', $student->trainer_id)->first();
    $emargancy_link = Helpline::first();

    return view('backend.student-panel.dashboard', compact('student', 'courses', 'my_tl', 'gifts', 'my_trainer', 'emargancy_link'));
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

        // ১. স্টুডেন্টের কোর্সের তথ্য রিলেশনসহ নিয়ে আসুন
        $course = \App\Models\Course::with('teacher')->find($student->course_id);

        // ২. লাইভ ক্লাস ফিল্টার করার সময় অবশ্যই $course->id ব্যবহার করতে হবে
        $liveclass = null;
        if ($course) {
            $liveclass = LiveClass::where('course_id', $course->id) // এখানে ভুল ছিল
                ->where('status', 'active')
                ->latest()
                ->first();
        }

        return view('backend.student-panel.course.course', compact('student', 'course', 'liveclass'));
    }

    public function viewAdmitCard()
    {
        // ১. লগইন করা স্টুডেন্টের তথ্য নিন (এটি নেভবারে ছবি ও নামের জন্য লাগবে)
        $student = auth()->guard('student')->user();

        // ২. স্টুডেন্টের এডমিট কার্ড খুঁজে বের করুন
        $admitCard = \App\Models\AdmitCard::where('student_id', $student->id)
            ->with('student')
            ->latest()
            ->first();

        // ৩. ভিউতে অবশ্যই 'student' ভ্যারিয়েবলটি পাঠাতে হবে
        return view('backend.student-panel.admit-card.admit-card', compact('admitCard', 'student'));
    }

    public function downloadAdmitCard($id)
    {
        $admitCard = \App\Models\AdmitCard::with('student')->find($id);

        // যদি আইডি ভুল হয় বা কার্ড না থাকে
        if (!$admitCard) {
            return redirect()->back()->with('error', 'Admit card not found!');
        }

        $pdf = Pdf::loadView('backend.student-panel.admit-card.admit-pdf', compact('admitCard'));
        return $pdf->download('AdmitCard.pdf');
    }

    public function viewResult()
    {
        // ১. লগইন করা স্টুডেন্টের তথ্য ও আইডি নিন
        $student = auth()->guard('student')->user();

        // ২. এই স্টুডেন্টের সকল রেজাল্ট নিয়ে আসা (লেটেস্টগুলো আগে)
        $results = \App\Models\Result::where('student_id', $student->id)
            ->latest()
            ->get();

        return view('backend.student-panel.result.view-result', compact('student', 'results'));
    }

    public function myExams()
    {
        $student = auth()->guard('student')->user();

        $exams = \App\Models\Exam::where('course_id', $student->course_id)
            ->where('status', 'approved')
            ->with('teacher')
            ->latest()
            ->get();

        return view('backend.student-panel.exams.exams', compact('exams', 'student'));
    }

    public function myCertificates()
    {
        $student = auth()->guard('student')->user();

        // স্টুডেন্টের সব সার্টিফিকেট নিয়ে আসা (কোর্স রিলেশনসহ)
        $certificates = \App\Models\Certificate::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->get();
        $student = auth()->guard('student')->user();
        return view('backend.student-panel.certificates.certificates', compact('certificates', 'student'));
    }

     public function downloadCertificate($id)
    {
        $certificate = Certificate::with(['student', 'course', 'result'])->findOrFail($id);

        // সাইট সেটিংস আলাদাভাবে পাস করতে হতে পারে যদি সেটি গ্লোবাল না হয়
        $sitesettings = Settings::first();

        $pdf = Pdf::loadView('backend.certificate.certificate-pdf', compact('certificate', 'sitesettings'))
            ->setPaper('a4', 'landscape')
            ->setOption(['isRemoteEnabled' => true, 'isHtml5ParserEnabled' => true]);

        return $pdf->download('Certificate_' . $certificate->student->name . '.pdf');
    }
}
