<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Education;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Payment;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class adminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminDashboard()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalCourses  = Course::count();
        $totalPayments = Payment::sum('amount');
        $recentStudents = Student::latest()->take(5)->get();
        $activeStudents = Student::where('status', 1)->count();
        $inactiveStudents = Student::where('status', 0)->count();
 
    // চার্ট ডেটা
    $chartData = [
        'students' => $totalStudents,
        'teachers' => $totalTeachers,
        'courses'  => $totalCourses,
    ];
        return view('backend.admin-dashboard', compact('totalStudents','totalTeachers','totalCourses', 'totalPayments','recentStudents','activeStudents','inactiveStudents','chartData'));
    }

    public function studentList()
    {
        $students = Student::with( 'course')->get();
        return view('backend.student.student-list', compact('students'));
    }

    public function updateStatus($id)
    {
        $student = Student::with('lock')->findOrFail($id);

    // 🔒 Locked check
    if ($student->lock && $student->lock->is_locked) {
        return redirect()->back()->with('error', 'This student is locked. Unlock first!');
    }

    $student->status = !$student->status;
    $student->save();

    return redirect()->back()->with('success', 'Student status updated.');
    }

    public function deleteStudent($id)
    {
        $students = Student::with('education')->find($id);

        if ($students->image && file_exists('backend/images/students/' . $students->image)) {
            unlink('backend/images/students/' . $students->image);
        }

        $students->delete();
        toastr()->success('Student ID' . $students->id, 'Deleted Successfully!');
        return redirect()->back();
    }

    public function editStudent($id)
    {
        $students = Student::with('education')->find($id);
        $courses = Course::all(); // সব কোর্স
        return view('backend.student.edit-student', compact('students', 'courses'));
    }


    public function updateStudent(Request $request, $id)
    {
        $student = Student::with('education', 'course')->find($id);

        $student->name              = $request->name;
        $student->father_name       = $request->father_name;
        $student->mother_name       = $request->mother_name;
        $student->dob               = $request->dob;
        $student->gender            = $request->gender;
        $student->email             = $request->email;
        $student->phone             = $request->phone;
        $student->blood             = $request->blood;
        $student->nationality       = $request->nationality;
        $student->religion          = $request->religion;
        $student->course_id         = $request->course_id;
        $student->present_address   = $request->present_address;
        $student->permanent_address = $request->permanent_address;

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            
            if ($student->image && file_exists(public_path('backend/images/students/' . $student->image))) {
                unlink(public_path('backend/images/students/' . $student->image));
            }

        
            $imageName = rand() . '-student' . '.' . $image->extension();
            $image->move(public_path('backend/images/students/'), $imageName);
            $student->image = $imageName;
        }

        $studentChanged = $student->isDirty(); // ডাটাবেজের সাথে মিলিয়ে দেখবে

        $student->save();

        // Education আপডেট (hasMany অনুযায়ী)
        $educationChanged = false;
        if (isset($request->ssc_passing_year) && $request->ssc_passing_year[0] != null) {
            // পুরানো Education রেকর্ড মুছে দিন
            Education::where('student_id', $student->id)->delete();

            // নতুন ডেটা যোগ করুন
            foreach ($request->ssc_passing_year as $key => $sscYear) {
                $education = new Education();
                $education->student_id        = $student->id;
                $education->ssc_passing_year  = $sscYear;
                $education->ssc_board         = $request->ssc_board[$key];
                $education->ssc_result        = $request->ssc_result[$key];
                $education->hsc_passing_year  = $request->hsc_passing_year[$key];
                $education->hsc_board         = $request->hsc_board[$key];
                $education->hsc_result        = $request->hsc_result[$key];
                $education->save();
            }
            $educationChanged = true;
        }


        // চেক করো কিছু পরিবর্তন হয়েছে কিনা
        if ($studentChanged || $educationChanged) {
            toastr()->success('Student info updated successfully!');
        } else {
            toastr()->info('No changes were made!');
        }

        return redirect('/admin/student/list');
    }

    // ContactMessege.....

    public function contactUs()
    {
        $contacts = Contact::get();
        return view('backend.contactmessege.contact-messege',  compact('contacts'));
    }

    public function contactUsDelete($id)
    {
        $contact = Contact::find($id);

        $contact->delete();
        Toastr()->success('Contact message deleted successfully!');
        return redirect()->back();
    }
}
