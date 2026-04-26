<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\Certificate;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Featured;
use App\Models\News;
use App\Models\Notice;
use App\Models\Policy;
use App\Models\Result;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherApplication;
use App\Models\Testimonial;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Yoeunes\Toastr\Facades\Toastr;

class FrontendController extends Controller
{
    public function index()
    {
        $teachers = Teacher::get();
        $courses = Course::with('Teacher')->get();
        $testimonials = Testimonial::get();
        $aboutus = AboutUs::first();
        $banners = Banner::get();
        $newspaper = News::where('status', 1)->latest()->get();
        $teachereatured = Featured::first();
        return view('frontend.index', compact('teachers', 'courses', 'testimonials', 'aboutus', 'banners', 'newspaper', 'teachereatured'));
    }

    public function aboutUs()
    {
        $aboutus = AboutUs::first();
        return view('frontend.about-us', compact('aboutus'));
    }

    public function courses()
    {
        $courses = Course::get();
        $teacher = Teacher::get();
        $student = Student::with('Course')->count();
        return view('frontend.courses', compact('courses', 'student', 'teacher'));
    }

    public function teachers()
    {
        $teachers = Teacher::get();
        return view('frontend.teachers', compact('teachers'));
    }

    public function teacherApplication()
    {
        return  view('frontend.teacher-application');
    }

    public function teacherApplicationStore(Request $request)
    {
        $teacherapplication = new TeacherApplication();

        $teacherapplication->name = $request->name;
        $teacherapplication->email = $request->email;
        $teacherapplication->phone = $request->phone;
        $teacherapplication->address = $request->address;
        $teacherapplication->qualification = $request->qualification;
        $teacherapplication->skills = $request->skills;
        $teacherapplication->experience = $request->experience;
        $teacherapplication->cover_letter = $request->cover_letter;

        // Image Upload
        if (isset($request->image)) {
            $imageName = rand() . '-applicate' . '.' . $request->image->extension();
            $request->image->move('backend/images/applicatecendidate/', $imageName);
            $teacherapplication->image = $imageName;
        }

        // CV Upload
        if (isset($request->cv)) {
            $fileName = rand() . '-cv' . '.' . $request->cv->extension();
            $request->cv->move('backend/file/cv/', $fileName);
            $teacherapplication->cv = $fileName;
        }

        // প্রথমে সেভ করে ID জেনারেট করি
        $teacherapplication->save();

        // Application ID তৈরি করি
        $application_id = 'TAC-' . str_pad($teacherapplication->id, 4, '0', STR_PAD_LEFT);
        $teacherapplication->application_id = $application_id;
        $teacherapplication->save();

        Toastr()->success('Your Application Submitted. Your Application ID:' . $application_id);
        return redirect()->route('frontend.application.success', ['application_id' => $application_id]);
    }

    public function teacherApplicationSuccess($application_id)
    {
        return view('frontend.application-success', compact('application_id'));
    }

    // Show form
    public function showApplicationStatusForm()
    {
        return view('frontend.teacher-application-status');
    }

    // Check status
    public function checkApplicationStatus(Request $request)
    {
        $request->validate([
            'application_id' => 'required|string',
        ]);

        $application = TeacherApplication::where('application_id', $request->application_id)->first();

        if ($application) {
            return view('frontend.teacher-application-status', compact('application'));
        } else {
            return redirect()->back()->with('error', 'Application ID not found!');
        }
    }


    public function teacherInfo($id)
    {
        $teachers = Teacher::find($id);
        $courses = Course::find($id);
        return view('frontend.teacher-info', compact('teachers', 'courses'));
    }

    // Show the result form
    public function studentResult()
    {
        return view('frontend.student-result'); // Blade form
    }

    // Handle form submission and show result
    public function showResult(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $result = Result::with('student')->where('student_id', $request->student_id)->first();

        if (!$result) {
            return back()->with('error', 'No result found for this Student ID');
        }

        return view('frontend.result_view', compact('result'));
    }

    public function downloadResult($id)
    {
        $result = Result::with('student.course')->findOrFail($id);

        // উপরে Pdf ফাসাদ ইমপোর্ট করা আছে, তাই সরাসরি Pdf:: ব্যবহার করা যাবে
        $pdf = Pdf::loadView('frontend.result-pdf', compact('result'));

        return $pdf->download('Result_' . $result->student->name . '.pdf');
    }

    public function contactUs()
    {
        return view('frontend.contact-us');
    }

    public function contactUsStore(Request $request)
    {
        $contactUs = new Contact();

        $contactUs->name = $request->name;
        $contactUs->email = $request->email;
        $contactUs->subject = $request->subject;
        $contactUs->phone = $request->phone;
        $contactUs->message = $request->message;

        $contactUs->save();
        toastr()->success('Your Messege Send Successfully.');
        return redirect()->back();
    }

    public function courseDetails($id)
    {
        $course = Course::with('teacher')->find($id);
        return view('frontend.course-details', compact('course'));
    }

    public function admission()
    {
        $courses = Course::get();
        return view('frontend.admission', compact('courses'));
    }

    public function admissionStore(Request $request)
    {
        // --- Student Data Save ---
        $student = new Student();

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
        $student->password         = Hash::make($request->password);
        $student->referral_code = Str::upper(Str::random(8)); // unique code
        $student->referred_by = $request->ref; // hidden input from referral link

        // --- Image Upload ---
        if (isset($request->image)) {
            $imageName = rand() . '-student' . '.' . $request->image->extension(); //12345-student-.webp
            $request->image->move('backend/images/students/', $imageName);

            $student->image = $imageName;
        }

        $student->present_address   = $request->address;
        $student->permanent_address = $request->permanent_address;
        $student->save();

        return redirect('/student/login');
    }

    public function print($id)
    {
        $student = Student::with('education')->find($id);

        // শুধু Print View দেখাতে চাইলে
        return view('frontend.admission-print', compact('student'));

        // যদি PDF দিতে চাস:
        // $pdf = PDF::loadView('admission.print', compact('student'));
        // return $pdf->download('application_copy.pdf');
    }

    public function checkForm()
    {
        return view('frontend.check-certificate');
    }

    // Handle certificate status check
    public function checkStatus(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $certificate = Certificate::where('student_id', $request->student_id)->first();

        if ($certificate) {
            // Certificate generated
            return view('frontend.certificate-status', [
                'message' => "আপনার সার্টিফিকেট জেনারেট হয়েছে। সার্টিফিকেট নাম্বার: " . $certificate->certificate_no
            ]);
        } else {
            // Not generated yet
            return view('frontend.certificate-status', [
                'message' => "আপনার সার্টিফিকেট এখনও জেনারেট হয়নি।"
            ]);
        }
    }

    // Notice section

    public function notice()
    {
        $notices = Notice::where('status', 1)->orderBy('created_at', 'desc')->get();
        return view('frontend.notice', compact('notices'));
    }

    public function show($id)
    {
        $notice = Notice::where('status', 1)->find($id);
        return view('frontend.show-notice', compact('notice'));
    }

    public function privacyPolicy()
    {
        $privacyPolicy = Policy::select('privacy_policy')->first();
        return view('frontend.privacy-policy', compact('privacyPolicy'));
    }

    public function tramsCondition()
    {
        $privacyPolicy = Policy::select('trams_condition')->first();
        return view('frontend.trams-Condition', compact('privacyPolicy'));
    }

    public function admissionPolicy()
    {
        $privacyPolicy = Policy::select('admission_policy')->first();
        return view('frontend.admission-policy', compact('privacyPolicy'));
    }

    public function paymentPolicy()
    {
        $privacyPolicy = Policy::select('payment_policy')->first();
        return view('frontend.payment-policy', compact('privacyPolicy'));
    }


    //Student Panel//
    public function studentLogin()
    {
        return view('frontend.studentLogin');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // প্রথমে লগইন অ্যাটেম্পট করা হচ্ছে
        if (Auth::guard('student')->attempt($credentials)) {

            $student = Auth::guard('student')->user();

            // চেক করা হচ্ছে স্টুডেন্ট লকড কি না
            // এখানে 'lock' হলো স্টুডেন্ট মডেলের রিলেশনশিপ নাম
            if ($student->lock && $student->lock->is_locked) {

                Auth::guard('student')->logout(); // লগইন হয়ে গেলেও তাকে বের করে দাও

                return redirect()->back()->with('error', 'আপনার অ্যাকাউন্টটি লক করা হয়েছে। দয়া করে কর্তৃপক্ষের সাথে যোগাযোগ করুন।');
            }

            return redirect()->intended(route('student.dashboard'));
        }

        return back()->with('error', 'Invalid Email or Password');
    }


    //Subadmin Panel//
    public function subadminLogin()
    {
        return view('frontend.Subadmin-login');
    }

    public function subadminLoginSubmit(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'position' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('subadmin')->attempt($credentials)) {
            $user = Auth::guard('subadmin')->user();

            // ২. ফর্মের পজিশন আর ডাটাবেসের পজিশন ম্যাচ করা
            if ($user->position !== $request->position) {
                Auth::guard('subadmin')->logout();
                return back()->with('error', 'আপনার সিলেক্ট করা পজিশনটি সঠিক নয়।');
            }

            // ৩. স্ট্যাটাস চেক
            if ($user->status == 0) {
                Auth::guard('subadmin')->logout();
                return back()->with('error', 'আপনার অ্যাকাউন্টটি বর্তমানে বন্ধ আছে।');
            }

            // ৪. পজিশন অনুযায়ী ডাইনামিক রিডাইরেক্ট
            if ($user->position == 'teacher') {
                toastr()->success('স্বাগতম টিচার প্যানেলে');
                return redirect()->route('teacher.dashboard');
            } elseif ($user->position == 'team_leader') {
                toastr()->success('স্বাগতম টিম লিডার প্যানেলে');
                return redirect()->route('team_leader.dashboard');
            } elseif ($user->position == 'trainer') {
                toastr()->success('স্বাগতম ট্রেইনার প্যানেলে');
                return redirect()->route('trainer.dashboard');
            } elseif ($user->position == 'helpline') {
                toastr()->success('স্বাগতম হেল্পলাইন প্যানেলে');
                return redirect()->route('helpline.dashboard');
            } elseif ($user->position == 'counsellor') {
                toastr()->success('স্বাগতম কাউন্সেলর প্যানেলে');
                return redirect()->route('counsellor.dashboard');
            }
            // elseif ($user->position == 'manager') {
            //     return redirect()->route('manager.dashboard');
            // }

            // ডিফল্ট রিডাইরেক্ট যদি কোনো রোল না মিলে
            return redirect()->intended('/panel/dashboard');
        }

        return back()->with('error', 'আপনার দেওয়া তথ্যগুলো সঠিক নয়।');
    }
    public function subadminLogout()
    {
        Auth::guard('subadmin')->logout();
        return redirect('/subadmin/login');
    }

    //=============Course React==================//
    public function toggleWishlist($course_id)
    {
        $user_ip = request()->ip(); // ইউজারের আইপি নেওয়া হচ্ছে

        $exists = Wishlist::where('ip_address', $user_ip)
            ->where('course_id', $course_id)
            ->first();

        if ($exists) {
            $exists->delete(); // একবার রিয়েক্ট দেওয়া থাকলে ক্লিক করলে চলে যাবে
        } else {
            Wishlist::create([
                'ip_address' => $user_ip,
                'course_id' => $course_id
            ]); // নতুন রিয়েক্ট যোগ হবে
        }

        return back();
    }
}
