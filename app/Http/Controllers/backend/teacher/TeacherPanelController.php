<?php

namespace App\Http\Controllers\backend\teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LiveClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('subadmin.role:teacher');
    }

    public function teacherDashboard()
    {
        $subadmin = Auth::guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        // ১. ব্যালেন্স
        $totalBalance = $teacher->points ?? 0;

        // ২. কোর্স লিস্ট ও টোটাল কোর্স
        $courses = \App\Models\Course::where('teacher_id', $teacher->id)->get();
        $totalCourses = $courses->count();

        // ৩. টোটাল স্টুডেন্ট কাউন্ট (রিলেশন ব্যবহার করে)
        $totalStudents = 0;
        foreach ($courses as $course) {
            // আপনি studentList-এ যেভাবে $course->students ব্যবহার করেছেন, এখানেও তাই
            $totalStudents += $course->students()->count();
        }

        return view('backend.teacher-panel.dashboard', compact('teacher', 'totalBalance', 'totalCourses', 'totalStudents'));
    }

    public function liveClass()
    {
        $subadmin = Auth::guard('subadmin')->user();

        // subadmins (id 6) -> teachers (subadmin_id 6, id 2)
        $teacherProfile = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        if ($teacherProfile) {
            // teachers (id 2) -> courses (teacher_id 2)
            $course = \App\Models\Course::where('teacher_id', $teacherProfile->id)->first();
        } else {
            $course = null;
        }

        // শুধুমাত্র এই কোর্সের জন্য লাইভ ক্লাসগুলো আনুন
        $classes = $course ? LiveClass::where('course_id', $course->id)->latest()->get() : collect();

        return view('backend.teacher-panel.live-class', compact('classes', 'course'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'title'        => 'required',
            'meeting_link' => 'required|url',
        ]);

        // নির্দিষ্ট কোর্সের জন্য লিঙ্ক আপডেট বা তৈরি করুন
        LiveClass::updateOrCreate(
            ['course_id' => $request->course_id],
            [
                'title'        => $request->title,
                'meeting_link' => $request->meeting_link,
                'status'       => 'active',
            ]
        );

        return back()->with('success', 'Live Class link updated successfully for this course!');
    }

    public function destroy($id)
    {
        LiveClass::findOrFail($id)->delete();
        return back()->with('success', 'লিঙ্কটি ডিলিট করা হয়েছে।');
    }

    public function toggleStatus($id)
    {
        $class = LiveClass::findOrFail($id);

        // যদি active থাকে তবে expired হবে, আর না হয় active হবে
        $class->status = ($class->status == 'active') ? 'expired' : 'active';
        $class->save();

        return back()->with('success', 'Class status updated successfully!');
    }

    // TeacherPanelController.php এ স্টুডেন্ট লিস্ট আনা
    public function studentList()
    {
        $subadmin = Auth::guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();
        $course = \App\Models\Course::where('teacher_id', $teacher->id)->first();

        // যদি রিলেশন মডেলে সেট করা থাকে (Many-to-Many)
        $students = $course->students;

        return view('backend.teacher-panel.student-list', compact('students'));
    }

    public function withdraw()
    {
        $subadmin = Auth::guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        // এই টিচারের সব উইথড্র রিকোয়েস্ট লেটেস্ট অনুযায়ী আনা
        $withdrawals = \App\Models\Withdrawal::where('teacher_id', $teacher->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.teacher-panel.withdraw', compact('teacher', 'withdrawals'));
    }

    public function withdrawStore(Request $request)
    {
        $subadmin = Auth::guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        // ভ্যালিডেশন: ব্যালেন্সের বেশি টাকা তুলতে পারবে না
        if ($request->amount > $teacher->points) {
            return back()->with('error', 'আপনার পর্যাপ্ত ব্যালেন্স নেই!');
        }

        \App\Models\Withdrawal::create([
            'teacher_id' => $teacher->id,
            'amount' => $request->amount,
            'method' => $request->method,
            'account_details' => $request->account_details,
            'status' => 'pending'
        ]);

        return back()->with('success', 'আপনার উইথড্র রিকোয়েস্টটি পেন্ডিং আছে।');
    }

    public function transactionHistory()
    {
        $subadmin = Auth::guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        $transactions = \App\Models\Transaction::where('teacher_id', $teacher->id)
            ->orderBy('id', 'desc')
            ->paginate(10); // ১০টি করে দেখাবে

        return view('backend.teacher-panel.transactions', compact('transactions'));
    }

    public function examCreate()
    {
        $courses = \App\Models\Course::all(); // এই লাইনটি জরুরি
        return view('backend.teacher-panel.exams-create', compact('courses'));
    }

    public function examStore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'course_id' => 'required',
            'exam_file' => 'required|mimes:pdf,docx,jpg,png|max:10240',
        ]);

        $subadmin = auth()->guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        $exam = new \App\Models\Exam();
        $exam->title = $request->title;
        $exam->teacher_id = $teacher->id;
        $exam->course_id = $request->course_id;
        $exam->exam_date = $request->exam_date ?? now();
        $exam->status = 'pending';

        if ($request->hasFile('exam_file')) {
            $file = $request->file('exam_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/files/exams/'), $fileName);
            $exam->exam_file = $fileName;
        }

        $exam->save();
        return redirect()->back()->with('success', 'Exam file uploaded. Waiting for Admin approval.');
    }

    public function myExams()
    {
        $subadmin = auth()->guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        $exams = \App\Models\Exam::where('teacher_id', $teacher->id)->latest()->get();
        $courses = \App\Models\Course::all(); // ড্রপডাউনের জন্য এটি যোগ করুন

        return view('backend.teacher-panel.exams-create', compact('exams', 'courses'));
    }

    public function examDelete($id)
    {
        $exam = \App\Models\Exam::find($id);

        // ১. পাবলিক ফোল্ডার থেকে ফাইলটি ডিলিট করা
        if ($exam->exam_file) {
            $filePath = public_path('backend/files/exams/' . $exam->exam_file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // ২. ডাটাবেজ থেকে ডিলিট করা
        $exam->delete();

        return back()->with('success', 'পরীক্ষার ফাইলটি সফলভাবে ডিলিট করা হয়েছে।');
    }
}
