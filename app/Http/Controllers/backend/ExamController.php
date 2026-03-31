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
        return view('backend.exam.exam-create');
    }

    public function examStore(Request $request)
    {
        $exam = new Exam();

        $exam->title = $request->title;
        $exam->exam_date = $request->exam_date;

         if(isset($request->exam_file)){
            $imageName = rand().'.'.'exam'.'.'.$request->exam_file->extension();
            $request->exam_file->move('backend/file/exam/', $imageName);
            
            $exam->exam_file = $imageName; 
        }

        $exam->save();
        Toastr()->success('Exam File Upload Successfully!');
        return redirect()->back();
    }

    public function examDelete($id)
    {
        $exam = Exam::find($id);
        
         if($exam->exam_file && file_exists('backend/file/exam/'.$exam->exam_file)){
            unlink('backend/file/exam/'.$exam->exam_file);
        }
        $exam->delete();
        Toastr()->success('Exam File Delete Successfully!');
        return redirect()->back();
    }
}
