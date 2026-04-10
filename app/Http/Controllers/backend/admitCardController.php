<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admitCard;
use App\Models\Course;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class admitCardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function admitCard()
    {
        $admitcard = admitCard::with('student')->get();
        return view('backend.admit-card.admit-card', compact('admitcard'));
    }

    public function admitCardCreate()
    {
        $students = Student::get();
        $courses = Course::orderBy('title', 'asc')->get();
        return view('backend.admit-card.create-admitcard', compact('students', 'courses'));
    }

    public function getStudentCourse($id)
    {
        // স্টুডেন্টের সাথে তার কোর্স ডাটা লোড করা
        $student = Student::with('course')->find($id);

        if ($student && $student->course) {
            return response()->json([
                'course_id'    => $student->course->id,    // এটি ড্রপডাউন সিলেক্ট করার জন্য
                'course_title' => $student->course->title, // এটি নিশ্চিত হওয়ার জন্য
            ]);
        }
        return response()->json(null);
    }

    public function admitCardStore(Request $request)
    {
        // ১. প্রথমে কোর্সটি ডাটাবেজ থেকে খুঁজে বের করুন (নাম পাওয়ার জন্য)
        $course = \App\Models\Course::find($request->course_id);

        // ২. নতুন এডমিট কার্ড অবজেক্ট তৈরি করুন
        $admitcard = new admitCard();

        $admitcard->student_id = $request->student_id;

        // ৩. 'course' কলামে কোর্সের টাইটেল/নাম সেভ করুন
        // যদি আপনার Course টেবিলে কলামের নাম 'title' হয় তবে $course->title লিখুন
        $admitcard->course = $course ? $course->title : 'N/A';

        $admitcard->exam = $request->exam;
        $admitcard->exam_date = $request->exam_date;
        $admitcard->seat_no = $request->seat_no;

        // ৪. ডাটা সেভ করুন
        $admitcard->save();

        Toastr()->success('Admit Card Generated Successfully!');
        return redirect('/admin/admit-card');
    }

    public function printadmit($id)
    {
        $admitCard = AdmitCard::with('student')->findOrFail($id);
        return view('backend.admit-card.admit-print', compact('admitCard'));
    }

    public function admitDelete($id)
    {
        $admitdelete = admitCard::find($id);

        $admitdelete->delete();
        Toastr()->success('Admit Card Delete Successfully!');
        return redirect()->back();
    }

    public function admitEdit($id)
    {
        $student = Student::get();
        $admitcard = admitCard::find($id);
        return view('backend.admit-card.edit-admit-card', compact('admitcard', 'student'));
    }

    public function admitUpdate(Request $request, $id)
    {
        $admitcard = admitCard::find($id);

        $admitcard->course = $request->course;
        $admitcard->exam = $request->exam;
        $admitcard->exam_date = $request->exam_date;
        $admitcard->seat_no = $request->seat_no;

        $admitcard->save();
        Toastr()->success('Admit Card Update Successfully!');
        return redirect('/admin/admit-card');
    }

    public function downloadAdmitCard($id)
    {
        // স্টুডেন্ট রিলেশনসহ ডাটা নিয়ে আসা
        $admitCard = admitCard::with('student')->findOrFail($id);

        // সেটিংস থেকে লোগো বা অন্য তথ্য নিতে চাইলে
        $sitesettings = \App\Models\Settings::first();

        // পিডিএফ এর জন্য তৈরি করা ভিউ ফাইলটি লোড করা
        $pdf = Pdf::loadView('backend.admit-card.admit-pdf', compact('admitCard', 'sitesettings'))
            ->setPaper('a4', 'portrait');

        // ফাইলটি ডাউনলোড হবে
        return $pdf->download('AdmitCard_' . $admitCard->student->id . '.pdf');
    }
}
