<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\admitCard;
use App\Models\Student;
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
        return view('backend.admit-card.create-admitcard', compact('students'));
    }

    public function admitCardStore(Request $request)
    {
        $admitcard = new admitCard();

        $admitcard->student_id = $request->student_id;
        $admitcard->course = $request->course;
        $admitcard->exam = $request->exam;
        $admitcard->exam_date = $request->exam_date;
        $admitcard->seat_no = $request->seat_no;

        $admitcard->save();
        Toastr()->success('Admit Card Generate Successfully!');
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
}
