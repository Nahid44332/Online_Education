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

    public function exam()
    {
        $exams = Exam::latest()->get();
        return view('backend.exam.exam-list', compact('exams'));
    }

    public function examCreate(Request $request)
    {
        $exams = Exam::with(['teacher', 'course'])->latest()->get();
        $teachers = \App\Models\Teacher::all();
        $courses = \App\Models\Course::all();
        return view('backend.exam.exam-create', compact('exams', 'teachers', 'courses'));
    }

    public function examStore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'teacher_id' => 'required',
            'course_id' => 'required',
            'exam_file' => 'required|mimes:pdf,docx,jpg,png|max:10240',
        ]);

        $exam = new Exam();
        $exam->title = $request->title;
        $exam->teacher_id = $request->teacher_id;
        $exam->course_id = $request->course_id;
        $exam->exam_date = $request->exam_date ?? now();

        if ($request->hasFile('exam_file')) {
            $file = $request->file('exam_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/files/exams/'), $fileName);
            $exam->exam_file = $fileName;
        }

        $exam->save();
        return back()->with('success', 'Exam file uploaded successfully!');
    }

    public function examDelete($id)
    {
        $exam = Exam::find($id);

        if ($exam->exam_file && file_exists('backend/files/exams/' . $exam->exam_file)) {
            unlink('backend/files/exams/' . $exam->exam_file);
        }
        $exam->delete();
        Toastr()->success('Exam File Delete Successfully!');
        return redirect()->back();
    }
}
