<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Result;
use App\Models\Student;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class CertificateController extends Controller
{
      public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function studentCertificate(Request $request)
    {
        $query = Certificate::with(['student', 'course', 'result'])->latest();

        if ($request->search) {
        $search = $request->search;
        $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('id', $search);
            })
            ->orWhere('certificate_no', 'like', "%{$search}%")
            ->orWhereHas('course', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
    }

    $certificates = $query->paginate(10);

    return view('backend.certificate.certificate', compact('certificates'));
    }


    public function studentCertificateCreate()
    {
        $students = Student::get();
        $courses = Course::get();
        return view('backend.certificate.create', compact('students', 'courses'));
    }

    public function certificateStore(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
            'issue_date' => 'required|date',
        ]);

        $student_id = $request->student_id;

        // চেক করা student রেজাল্ট আছে কি না
        $result = Result::where('student_id', $student_id)->first();
        if (!$result) {
            return redirect()->back()->with('error', 'Cannot generate certificate. Student has no exam result.');
        }

        // Last certificate বের করা
        $lastCertificate = Certificate::latest()->first();
        $nextId = $lastCertificate ? $lastCertificate->id + 1 : 1;

        // Auto Generate Certificate No → NCTC-2025-001
        $certificateNo = 'NCTC-' . date('Y') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Save certificate
        $certificate = new Certificate();
        $certificate->student_id     = $student_id;
        $certificate->course_id      = $request->course_id;
        $certificate->issue_date     = $request->issue_date;
        $certificate->certificate_no = $certificateNo;

        $certificate->save();
        Toastr()->success('Certificate Generated Successfully!');
        return redirect()->back();
    }
    public function certificateView($id)
    {
        $certificate = Certificate::with(['student', 'course'])->findOrFail($id);
        return view('backend.certificate.view', compact('certificate'));
    }

    public function certificatePrint($id)
    {
        $certificate = Certificate::with(['student', 'course'])->findOrFail($id);
        return view('backend.certificate.print', compact('certificate'));
    }

    public function certificateDelete($id)
    {
        $certificate = Certificate::find($id);
        
        $certificate->delete();
        Toastr()->success('Certificate Delete Successfully!');
        return redirect()->back();
    }
}
