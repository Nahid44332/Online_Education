<?php

namespace App\Http\Controllers\backend\teacher;

use App\Http\Controllers\Controller;
use App\Models\Counsellor;
use App\Models\Course;
use App\Models\LiveClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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
        $subadminId = Auth::guard('subadmin')->id();

        // সরাসরি teachers টেবিল থেকে ওই টিচারের ডাটা আনা
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadminId)->first();
        if (!$teacher) {
            return back()->with('error', 'মামা, টিচার ডাটা পাওয়া যায়নি!');
        }

        // ঐ টিচারের কোর্সের স্টুডেন্ট লিস্ট আনা
        $course = \App\Models\Course::where('teacher_id', $teacher->id)->first();
        $students = $course ? $course->students : collect();

        return view('backend.teacher-panel.student-list', compact('students', 'teacher'));
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

    public function profile()
{
    $user = Auth::guard('subadmin')->user();
    
    // সরাসরি টিচার টেবিল থেকে ডাটা আনা
    $teacher = DB::table('teachers')->where('subadmin_id', $user->id)->first();

    // টিচারের সাথে রিলেটেড কোর্স আনা
    $course = null;
    if ($teacher) {
        $course = DB::table('courses')->where('teacher_id', $teacher->id)->first();
    }

    return view('backend.teacher-panel.profile', compact('teacher', 'user', 'course'));
}

    public function editProfile()
    {
        $teacher = Auth::guard('subadmin')->user()->teacher;
        return view('backend.teacher-panel.edit-profile', compact('teacher'));
    }

    public function updateProfile(Request $request)
    {
        // ১. ডাটা ভ্যালিডেশন
        $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'blood'         => 'nullable|string|max:5',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // সর্বোচ্চ ২ মেগাবাইট
        ]);

        // ২. লগইন করা টিচারকে খুঁজে বের করা
        $teacher = Auth::guard('subadmin')->user()->teacher;

        // ৩. বেসিক তথ্য আপডেট
        $teacher->name  = $request->name;
        $teacher->phone = $request->phone;
        $teacher->blood = $request->blood;

        // ৪. প্রোফাইল পিকচার হ্যান্ডেল করা
        if ($request->hasFile('profile_image')) {

            // পুরানো ইমেজ থাকলে সেটা ফোল্ডার থেকে ডিলিট করে দেওয়া (Clean up)
            $oldImagePath = public_path('backend/images/teachers/' . $teacher->profile_image);
            if (File::exists($oldImagePath) && $teacher->profile_image != 'default.png') {
                File::delete($oldImagePath);
            }

            // নতুন ইমেজ সেভ করা
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/images/teachers'), $imageName);

            // ডাটাবেজে ইমেজের নাম রাখা
            $teacher->profile_image = $imageName;
        }

        // ৫. সেভ করা
        $teacher->save();

        return redirect()->route('teacher.view-profile')->with('success', 'মামা, প্রোফাইল একদম সাকসেসফুলি আপডেট হয়েছে!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6', // password_confirmation ইনপুট ফিল্ড থাকতে হবে
        ]);

        $user = auth()->user(); // আপনার সাব-অ্যাডমিন গার্ড থেকে ইউজার

        // পুরানো পাসওয়ার্ড চেক
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->with('error', 'মামা, পুরানো পাসওয়ার্ড তো মিললো না!');
        }

        // নতুন পাসওয়ার্ড আপডেট
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'পাসওয়ার্ড একদম কড়কড়ে নতুন হয়ে গেছে!');
    }

    public function studentResults()
    {
        $subadmin = Auth::guard('subadmin')->user();
        $teacher = \App\Models\Teacher::where('subadmin_id', $subadmin->id)->first();

        // ১. এই টিচারের আন্ডারে থাকা কোর্সের আইডিগুলো নিন
        $courseIds = \App\Models\Course::where('teacher_id', $teacher->id)->pluck('id');

        // ২. রেজাল্ট ফিল্টার (স্টুডেন্টের কোর্স আইডি ধরে)
        $results = \App\Models\Result::whereHas('student', function ($query) use ($courseIds) {
            // স্টুডেন্ট টেবিলের course_id যদি টিচারের কোর্স আইডিগুলোর মধ্যে থাকে
            $query->whereIn('course_id', $courseIds);
        })
            ->with(['student'])
            ->latest()
            ->get();

        return view('backend.teacher-panel.student-results', compact('results'));
    }

    public function giftPoint(Request $request)
{
    $request->validate([
        'student_id' => 'required',
        'amount'     => 'required|numeric|min:1',
    ]);

    // ১. লগইন করা subadmin এর আইডি দিয়ে teachers টেবিল থেকে রেকর্ড আনা
    $teacherData = \App\Models\Teacher::where('subadmin_id', Auth::guard('subadmin')->id())->first();

    if (!$teacherData) {
        return back()->with('error', 'মামা, টিচার প্রোফাইল খুঁজে পাওয়া যায়নি!');
    }

    // ২. ব্যালেন্স চেক (সরাসরি টিচার টেবিল থেকে)
    if ($teacherData->points < $request->amount) {
        return back()->with('error', 'মামা, আপনার যথেষ্ট পয়েন্ট নেই!');
    }

    DB::transaction(function () use ($teacherData, $request) {
        // ৩. টিচার টেবিল থেকে পয়েন্ট কমানো
        DB::table('teachers')->where('id', $teacherData->id)->decrement('points', $request->amount);

        // ৪. স্টুডেন্ট টেবিল থেকে পয়েন্ট বাড়ানো
        DB::table('students')->where('id', $request->student_id)->increment('points', $request->amount);

        // ৫. ট্রানজেকশন টেবিল আপডেট (আপনার স্ক্রিনশটের স্ট্রাকচার অনুযায়ী)
        DB::table('transactions')->insert([
            'teacher_id'    => $teacherData->id, // এখানে টিচারের প্রাইমারি আইডি বসবে
            'amount'        => $request->amount,
            'type'          => 'debit', // যেহেতু টিচারের থেকে কমছে, তাই ডেবিট
            'description'   => 'Gifted to Student ID: ' . $request->student_id,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    });

    return back()->with('success', 'পয়েন্ট গিফট করা হয়েছে! ট্রানজেকশন রেকর্ড সেভ হয়েছে। 😍');
}
}
