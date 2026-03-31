<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function allReports() {
        $totalstudents = Student::count();
        $totateachers = Teacher::count();
        $totacourses = Course::count();
        $totapayments = Payment::count();
        $totacertificates = Certificate::count();

        $students = Student::get();
        $teachers = Teacher::get();
        $courses = Course::get();
        $payments = Payment::get();
        $certificates = Certificate::get();
        return view('backend.report.all-report', compact('students', 'totalstudents', 'teachers', 'totateachers',  'courses', 'totacourses', 'payments', 'totapayments', 'certificates', 'totacertificates'));
    }

    public function studentReports() {
        $students = Student::all();
        $totalstudents = Student::count();
        return view('backend.report.students', compact('students', 'totalstudents'));
    }

    public function teacherReports() {
        $teachers = Teacher::with('courses')->get();
        $totateachers = Teacher::count();
        return view('backend.report.teachers', compact('teachers', 'totateachers'));
    }

    public function courseReports() {
        $courses = Course::all();
        $totacourses = Course::count();
        return view('backend.report.courses', compact('courses', 'totacourses'));
    }

    public function paymentReports() {
        $payments = Payment::with('student', 'course')->get();
        $totapayments = Payment::count();
        return view('backend.report.payments', compact('payments', 'totapayments'));
    }

    public function certificateReports() {
        $certificates = Certificate::with('student', 'course')->get();
        $totacertificates = Certificate::count();
        return view('backend.report.certificates', compact('certificates', 'totacertificates'));
    }
}
