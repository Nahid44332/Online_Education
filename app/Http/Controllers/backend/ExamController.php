<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // সব এক্সাম লিস্ট দেখার জন্য
    public function examList()
    {
        // টিচার এবং কোর্সের নামসহ সব ডাটা নিয়ে আসা
        $exams = \App\Models\Exam::with(['teacher', 'course'])->latest()->get();
        return view('backend.exam.exam-list', compact('exams'));
    }

    // এক্সাম অ্যাপ্রুভ করার জন্য
    public function approveExam($id)
    {
        $exam = \App\Models\Exam::find($id);
        $exam->status = 'approved';
        $exam->save();

        return back()->with('success', 'পরীক্ষার ফাইলটি সফলভাবে অ্যাপ্রুভ করা হয়েছে। এটি এখন স্টুডেন্টরা দেখতে পাবে।');
    }

    public function examDelete($id)
    {
        $exam = \App\Models\Exam::findOrFail($id);

        // ১. সার্ভার/ফোল্ডার থেকে ফাইলটি ডিলিট করা
        if ($exam->exam_file) {
            $filePath = public_path('backend/files/exams/' . $exam->exam_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // ২. ডাটাবেজ থেকে রেকর্ড ডিলিট করা
        $exam->delete();

        return back()->with('success', 'পরীক্ষার ফাইলটি চিরতরে ডিলিট করা হয়েছে।');
    }
}
