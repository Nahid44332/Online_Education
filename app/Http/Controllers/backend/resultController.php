<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class resultController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function studentResult()
    {
        $results = Result::with('student')->get();
        return view('backend.result.result', compact('results'));
    }

    public function createResult()
    {
        $students = Student::get();
        return view('backend.result.create-result', compact('students'));
    }

    public function storeResult(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'total_marks' => 'required|numeric|min:1',
            'marks_obtained' => 'required|numeric|min:0',
        ]);

        $marks = $request->marks_obtained;
        $total = $request->total_marks;
        $percentage = ($marks / $total) * 100;

        // Minimum pass 33%
        if ($percentage < 33) {
            $grade = 'F';
            $status = 'Fail';
        } else {
            // Grade & Status Logic
            if ($percentage >= 80) {
                $grade = 'A+';
                $status = 'Pass';
            } elseif ($percentage >= 70) {
                $grade = 'A';
                $status = 'Pass';
            } elseif ($percentage >= 60) {
                $grade = 'A-';
                $status = 'Pass';
            } elseif ($percentage >= 50) {
                $grade = 'B';
                $status = 'Pass';
            } elseif ($percentage >= 40) {
                $grade = 'C';
                $status = 'Pass';
            }
        }

        $result = new Result();
        $result->student_id = $request->student_id;
        $result->total_marks = $total;
        $result->marks_obtained = $marks;
        $result->status = $status;
        $result->grade = $grade;

        $result->save();

        Toastr()->success('Result Submitted Successfully');
        return redirect()->back();
    }

    public function deleteResult($id)
    {
        $result = Result::find($id);

        $result->delete();
        Toastr()->success('Result Delete Successfully');
        return redirect()->back();
    }

    public function editResult($id)
    {
        $result = Result::find($id);
        $students = Student::get();
        return  view('backend.result.edit-result', compact('students', 'result'));
    }

    public function updateResult(Request $request, $id)
    {
        $result = Result::find($id);

        $marks = $request->marks_obtained;
        $total = $request->total_marks;
        $percentage = ($marks / $total) * 100;

        // Minimum pass 33%
        if ($percentage < 33) {
            $grade = 'F';
            $status = 'Fail';
        } else {
            if ($percentage >= 80) {
                $grade = 'A+';
                $status = 'Pass';
            } elseif ($percentage >= 70) {
                $grade = 'A';
                $status = 'Pass';
            } elseif ($percentage >= 60) {
                $grade = 'A-';
                $status = 'Pass';
            } elseif ($percentage >= 50) {
                $grade = 'B';
                $status = 'Pass';
            } elseif ($percentage >= 40) {
                $grade = 'C';
                $status = 'Pass';
            }
        }

        $result->student_id = $request->student_id;
        $result->total_marks = $total;
        $result->marks_obtained = $marks;
        $result->status = $status;
        $result->grade = $grade;

        $result->save();
        Toastr()->success('Result Updated Successfully');
        return redirect('/admin/student/result');
    }
}
