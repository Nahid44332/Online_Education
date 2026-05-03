<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Counsellor;
use App\Models\Course;
use App\Models\Helpline;
use App\Models\Lock;
use App\Models\Manager;
use App\Models\Notice;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Subadmin;
use App\Models\Teacher;
use App\Models\TeamLeader;
use App\Models\Trainer;
use App\Models\Withdrawal;
use App\Models\WithdrawRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $active_students   = Student::where('status', '1')->count();
        $inactive_students   = Student::where('status', '0')->count();
        $total_students    = Student::count();
        $total_teachers    = Teacher::count();
        $total_trainer  = Trainer::count();
        $total_teamleader  = TeamLeader::count();
        $total_counsellor  = Counsellor::count();
        $total_helpline = Helpline::count();
        $total_earnings = Payment::sum('amount');
        $total_course = Course::count();
        $today_reg   = Student::whereDate('created_at', Carbon::today())->count();
        $today_active = Student::where('status', '1')
            ->whereDate('updated_at', Carbon::today())
            ->count();
        return view('backend.manager-panel.dashboard', compact(
            'managers',
            'active_students',
            'inactive_students',
            'total_students',
            'total_teachers',
            'total_trainer',
            'total_teamleader',
            'total_counsellor',
            'total_helpline',
            'total_earnings',
            'total_course',
            'today_reg',
            'today_active'
        ));
    }

    public function allStudent(Request $request, $status = null)
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();

        // কুয়েরি শুরু করুন
        $query = Student::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                    ->orWhere('phone', 'LIKE', "%$search%")
                    ->orWhere('id', 'LIKE', "%$search%");
            });
        }

        // যদি ইউআরএল এ স্ট্যাটাস থাকে, তবে ফিল্টার করুন
        if ($status == 'active') {
            $query->where('status', '1');
        } elseif ($status == 'inactive') {
            $query->where('status', '0');
        }

        $students = $query->latest()->get();

        return view('backend.manager-panel.students.student', compact('managers', 'students', 'status'));
    }

    public function updatePoints(Request $request)
    {
        $student = Student::findOrFail($request->student_id);
        // আগের পয়েন্টের সাথে নতুন পয়েন্ট যোগ করা
        $student->points = $student->points + $request->points;
        $student->save();

        return back()->with('success', 'Points updated successfully!');
    }

    public function viewStudent($id)
    {
        $student = Student::with('course')->find($id);

        if (!$student) {
            return "<p class='text-danger'>Student not found!</p>";
        }

        // ছোট একটা সুন্দর টেবিল রিটার্ন করছি যা মোডালে শো করবে
        return "
        <div class='text-center mb-3'>
            <img src='" . asset('backend/images/students/' . $student->image) . "' style='width:100px; height:100px; border-radius:50%; object-fit:cover; border: 2px solid #ddd;'>
            <h4 class='mt-2'>{$student->name}</h4>
        </div>
        <table class='table table-bordered'>
            <tr><th class='bg-light'>Phone</th><td>{$student->phone}</td></tr>
            <tr><th class='bg-light'>Course</th><td>" . ($student->course->title ?? 'N/A') . "</td></tr>
            <tr><th class='bg-light'>Points</th><td><span class='badge badge-info'>{$student->points}</span></td></tr>
            <tr><th class='bg-light'>Status</th><td>" . ($student->status == 1 ? 'Active' : 'Inactive') . "</td></tr>
            <tr><th class='bg-light'>Joined Date</th><td>" . $student->created_at->format('d M Y') . "</td></tr>
        </table>";
    }

    public function resetStudentPassword(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'new_password' => 'required|min:6',
        ]);

        $student = \App\Models\Student::find($request->student_id);

        // যদি স্টুডেন্টের লগইন ডিটেইলস subadmin টেবিলে থাকে (আপনার আগের কোড অনুযায়ী)
        $subadmin = \App\Models\Subadmin::find($student->subadmin_id);

        if ($subadmin) {
            $subadmin->password = Hash::make($request->new_password);
            $subadmin->save();

            return back()->with('success', 'স্টুডেন্টের পাসওয়ার্ড সফলভাবে আপডেট হয়েছে!');
        }

        return back()->with('error', 'স্টুডেন্ট অ্যাকাউন্ট পাওয়া যায়নি!');
    }
    public function trainer()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $query = \App\Models\Trainer::query();
        $trainers = $query->latest()->get();
        return view('backend.manager-panel.subadmin.trainer', compact('managers', 'trainers'));
    }

    public function viewTrainer($id)
    {
        // Eager Loading ব্যবহার করলে ডাটা ফাস্ট আসবে এবং এরর কম হবে
        $trainer = Trainer::with(['subadmin', 'teamLeader'])->find($id);

        if (!$trainer) {
            return "<p class='text-danger text-center'>Trainer not found!</p>";
        }

        $imagePath = asset('backend/images/trainer/' . $trainer->profile_image);

        // টিম লিডারের নাম চেক করা (যদি ডাটা না থাকে তবে 'N/A' দেখাবে)
        $teamLeaderName = $trainer->teamLeader ? $trainer->teamLeader->name : '<span class="text-muted">Not Assigned</span>';
        $email = $trainer->subadmin ? $trainer->subadmin->email : 'N/A';

        return "
    <div class='text-center mb-3'>
        <img src='{$imagePath}' 
             alt='{$trainer->name}' 
             style='width:120px; height:120px; border-radius:50%; object-fit:cover; border: 3px solid #6f42c1;'>
        <h4 class='mt-2'>{$trainer->name}</h4>
        <p class='text-muted'>ID: #TR-{$trainer->id}</p>
    </div>
    <table class='table table-bordered'>
        <tr><th>Phone</th><td>{$trainer->phone}</td></tr>
        <tr><th>Email</th><td>{$email}</td></tr>
        <tr><th>Team Leader</th><td><b class='text-primary'>{$teamLeaderName}</b></td></tr>
        <tr><th>Points</th><td><span class='badge badge-info'>{$trainer->points}</span></td></tr>
    </table>";
    }
    public function updateTrainerPoints(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'points' => 'required|integer',
        ]);

        $trainer = \App\Models\Trainer::find($request->trainer_id);
        // আগের পয়েন্টের সাথে নতুন পয়েন্ট যোগ হবে (নেগেটিভ দিলে বিয়োগ হবে)
        $trainer->points += $request->points;
        $trainer->save();

        return back()->with('success', 'Trainer points updated successfully!');
    }

    public function resetTrainerPassword(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:trainers,id',
            'new_password' => 'required|min:6',
        ]);

        // ট্রেইনারের মাধ্যমে তার সাব-অ্যাডমিন অ্যাকাউন্ট খুঁজে বের করা
        $trainer = \App\Models\Trainer::find($request->trainer_id);

        if ($trainer && $trainer->subadmin_id) {
            $subadmin = \App\Models\Subadmin::find($trainer->subadmin_id);

            if ($subadmin) {
                // পাসওয়ার্ড হ্যাশ করে আপডেট
                $subadmin->password = Hash::make($request->new_password);
                $subadmin->save();

                return back()->with('success', $trainer->name . '-এর পাসওয়ার্ড রিসেট সফল হয়েছে!');
            }
        }

        return back()->with('error', 'অ্যাকাউন্ট খুঁজে পাওয়া যায়নি!');
    }
    public function teamLeader()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $teamLeaders = TeamLeader::with('subadmin')->latest()->get();
        return view('backend.manager-panel.subadmin.team-leader', compact('managers', 'teamLeaders'));
    }

    public function viewLeader($id)
    {
        $leader = TeamLeader::with('subadmin')->find($id);

        if (!$leader) {
            return "<p class='text-danger text-center'>Leader not found!</p>";
        }

        $imagePath = asset('backend/images/team-leader/' . ($leader->profile_image ?? 'default.png'));
        $email = $leader->subadmin ? $leader->subadmin->email : 'N/A';

        return "
    <div class='text-center mb-3'>
        <img src='{$imagePath}' 
             alt='{$leader->name}' 
             style='width:120px; height:120px; border-radius:50%; object-fit:cover; border: 3px solid #007bff;'>
        <h4 class='mt-2'>{$leader->name}</h4>
        <p class='text-muted'>ID: #TL-{$leader->id}</p>
    </div>
    <table class='table table-bordered'>
        <tr><th>Phone</th><td>{$leader->phone}</td></tr>
        <tr><th>Email</th><td>{$email}</td></tr>
        <tr><th>Points</th><td><span class='badge badge-info'>{$leader->points}</span></td></tr>
    </table>";
    }

    public function updateLeaderPoints(Request $request)
    {
        $request->validate([
            'leader_id' => 'required|exists:team_leaders,id',
            'points' => 'required|integer',
        ]);

        $leader = TeamLeader::find($request->leader_id);
        $leader->points += $request->points;
        $leader->save();

        return back()->with('success', 'Leader points updated successfully!');
    }

    public function resetLeaderPassword(Request $request)
    {
        $request->validate([
            'leader_id' => 'required|exists:team_leaders,id',
            'new_password' => 'required|min:6',
        ]);

        // টিম লিডারের মাধ্যমে তার সাব-অ্যাডমিন অ্যাকাউন্ট খুঁজে বের করা
        $leader = \App\Models\TeamLeader::find($request->leader_id);

        if ($leader && $leader->subadmin_id) {
            $subadmin = \App\Models\Subadmin::find($leader->subadmin_id);

            if ($subadmin) {
                // নতুন পাসওয়ার্ড হ্যাশ করে আপডেট
                $subadmin->password = Hash::make($request->new_password);
                $subadmin->save();

                return back()->with('success', $leader->name . '-এর পাসওয়ার্ড সফলভাবে রিসেট হয়েছে!');
            }
        }

        return back()->with('error', 'অ্যাকাউন্ট খুঁজে পাওয়া যায়নি!');
    }

    // ১. কাউন্সেলর লিস্ট
    public function allCounselor()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $counselors = Counsellor::with('subadmin')->latest()->get();
        return view('backend.manager-panel.subadmin.counsellor', compact('counselors', 'managers'));
    }

    // ২. কাউন্সেলর ভিউ (Ajax)
    public function viewCounselor($id)
    {
        $counselor = Counsellor::with('subadmin')->find($id);
        if (!$counselor) return "<p class='text-danger'>Not found!</p>";

        $imagePath = asset('backend/images/counsellor/' . ($counselor->profile_image ?? 'default.png'));

        return "
    <div class='text-center mb-3'>
        <img src='{$imagePath}' style='width:100px; height:100px; border-radius:50%; object-fit:cover;'>
        <h4 class='mt-2'>{$counselor->name}</h4>
    </div>
    <table class='table table-bordered'>
        <tr><th>Phone</th><td>{$counselor->phone}</td></tr>
        <tr><th>Email</th><td>" . ($counselor->subadmin->email ?? 'N/A') . "</td></tr>
        <tr><th>Points</th><td>{$counselor->points}</td></tr>
    </table>";
    }

    // ৩. পাসওয়ার্ড রিসেট
    public function resetCounselorPassword(Request $request)
    {
        $request->validate(['counselor_id' => 'required', 'new_password' => 'required|min:6']);
        $counselor = Counsellor::find($request->counselor_id);

        if ($counselor && $counselor->subadmin_id) {
            $subadmin = Subadmin::find($counselor->subadmin_id);
            $subadmin->password = Hash::make($request->new_password);
            $subadmin->save();
            return back()->with('success', 'Counselor password reset successful!');
        }
        return back()->with('error', 'Something went wrong!');
    }

    public function updateCounselorPoints(Request $request)
    {
        $request->validate([
            'counselor_id' => 'required|exists:counsellors,id',
            'points' => 'required|numeric',
        ]);

        $counselor = Counsellor::find($request->counselor_id);

        if ($counselor) {
            // নতুন পয়েন্ট যোগ করা (পুরাতন পয়েন্ট + নতুন পয়েন্ট)
            $counselor->points = $counselor->points + $request->points;
            $counselor->save();

            return back()->with('success', 'পয়েন্ট সফলভাবে আপডেট হয়েছে!');
        }

        return back()->with('error', 'কাউন্সেলর পাওয়া যায়নি!');
    }

    // ১. টিচার লিস্ট ভিউ
    public function allTeacher()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $teachers = Teacher::with('subadmin')->latest()->get();
        return view('backend.manager-panel.subadmin.teacher', compact('teachers', 'managers'));
    }

    // ২. টিচার প্রোফাইল ভিউ (Ajax)
    public function viewTeacher($id)
    {
        $teacher = Teacher::with('subadmin')->find($id);
        if (!$teacher) return "<p class='text-danger'>Teacher not found!</p>";

        $imagePath = asset('backend/images/teachers/' . ($teacher->profile_image ?? 'default.png'));

        return "
    <div class='text-center mb-3'>
        <img src='{$imagePath}' style='width:100px; height:100px; border-radius:50%; object-fit:cover;'>
        <h4 class='mt-2'>{$teacher->name}</h4>
    </div>
    <table class='table table-bordered'>
        <tr><th>Phone</th><td>{$teacher->phone}</td></tr>
        <tr><th>Email</th><td>" . ($teacher->subadmin->email ?? 'N/A') . "</td></tr>
        <tr><th>Position</th><td>Teacher</td></tr>
        <tr><th>Points</th><td>{$teacher->points}</td></tr>
    </table>";
    }

    // ৩. টিচার পাসওয়ার্ড রিসেট
    public function resetTeacherPassword(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'new_password' => 'required|min:6'
        ]);

        $teacher = Teacher::find($request->teacher_id);

        if ($teacher && $teacher->subadmin_id) {
            $subadmin = Subadmin::find($teacher->subadmin_id);
            $subadmin->password = Hash::make($request->new_password);
            $subadmin->save();
            return back()->with('success', 'টিচারের পাসওয়ার্ড সফলভাবে রিসেট হয়েছে!');
        }
        return back()->with('error', 'অ্যাকাউন্ট খুঁজে পাওয়া যায়নি!');
    }

    public function updateTeacherPoints(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'points' => 'required|numeric',
        ]);

        $teacher = Teacher::find($request->teacher_id);

        if ($teacher) {
            // বর্তমান পয়েন্টের সাথে নতুন পয়েন্ট যোগ হবে
            $teacher->points = $teacher->points + $request->points;
            $teacher->save();

            return back()->with('success', 'টিচারের পয়েন্ট সফলভাবে আপডেট হয়েছে!');
        }

        return back()->with('error', 'টিচার পাওয়া যায়নি!');
    }

    // হেল্পলাইন লিস্ট দেখানো
    public function allHelpline()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();

        // এখান থেকে 'managers' রিলেশনটা বাদ দিয়ে দিন
        $helplines = \App\Models\Helpline::with('subadmin')->latest()->get();

        return view('backend.manager-panel.subadmin.helpline', compact('helplines', 'managers'));
    }

    // হেল্পলাইন প্রোফাইল ভিউ (Ajax এর মাধ্যমে লোড হবে)
    public function viewHelpline($id)
    {
        // হেল্পলাইন এবং তার সাবঅ্যাডমিন অ্যাকাউন্ট লোড করা
        $helpline = \App\Models\Helpline::with('subadmin')->find($id);

        if (!$helpline) {
            return "<p class='text-danger text-center'>Helpline member not found!</p>";
        }

        // ইমেজ পাথ চেক
        $imagePath = asset(($helpline->image ?? 'default.png'));

        // এই HTML-টাই আপনার ব্লেড ফাইলের মোডাল বডিতে গিয়ে বসবে
        return "
    <div class='text-center mb-4'>
        <img src='$imagePath' class='img-thumbnail shadow-sm' style='width:120px; height:120px; border-radius:50%; object-fit:cover;'>
        <h4 class='mt-3 text-primary'>{$helpline->name}</h4>
        <span class='badge badge-outline-info'>Helpline Member</span>
    </div>
    <div class='table-responsive'>
        <table class='table table-bordered'>
            <tr class='bg-light'>
                <th style='width: 40%;'>ID</th>
                <td>#HL-{$helpline->id}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>" . ($helpline->subadmin->email ?? 'N/A') . "</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>{$helpline->phone}</td>
            </tr>
            <tr>
                <th>Current Points</th>
                <td><b class='text-info'>{$helpline->points}</b></td>
            </tr>
            <tr>
                <th>Join Date</th>
                <td>" . $helpline->created_at->format('d M, Y') . "</td>
            </tr>
            <tr>
                <th>Status</th>
                <td><span class='text-success'><i class='mdi mdi-record'></i> Active</span></td>
            </tr>
        </table>
    </div>";
    }

    // পয়েন্ট আপডেট
    public function updateHelplinePoints(Request $request)
    {
        $request->validate([
            'helpline_id' => 'required|exists:helplines,id',
            'points' => 'required|numeric',
        ]);

        $helpline = \App\Models\Helpline::find($request->helpline_id);
        if ($helpline) {
            $helpline->points += $request->points;
            $helpline->save();
            return back()->with('success', 'হেল্পলাইন পয়েন্ট সফলভাবে আপডেট হয়েছে!');
        }
        return back()->with('error', 'হেল্পলাইন পাওয়া যায়নি!');
    }

    // পাসওয়ার্ড রিসেট
    public function resetHelplinePassword(Request $request)
    {
        $request->validate([
            'helpline_id' => 'required|exists:helplines,id',
            'new_password' => 'required|min:6',
        ]);

        $helpline = \App\Models\Helpline::find($request->helpline_id);
        $subadmin = \App\Models\Subadmin::find($helpline->subadmin_id);

        if ($subadmin) {
            $subadmin->password = Hash::make($request->new_password);
            $subadmin->save();
            return back()->with('success', 'হেল্পলাইন পাসওয়ার্ড রিসেট সফল হয়েছে!');
        }
        return back()->with('error', 'অ্যাকাউন্ট পাওয়া যায়নি!');
    }

    public function allCourses()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = \App\Models\Manager::where('subadmin_id', $user->id)->first();
        $courses = \App\Models\Course::withCount('students')->latest()->get();
        return view('backend.manager-panel.course.course', compact('courses', 'managers'));
    }

    // এডিটের জন্য ডাটা পাঠানো
    public function editCourse($id)
    {
        $course = Course::find($id);
        return response()->json($course);
    }

    // ডাটা আপডেট করা
    public function updateCourse(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'course_id'   => 'required|exists:courses,id',
            'title'       => 'required|string|max:255',
            'course_fee'  => 'required|numeric',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp,avif|max:2048',
        ]);

        try {
            $course = \App\Models\Course::findOrFail($request->course_id);
            $course->title = $request->title;
            $course->course_fee = $request->course_fee;

            if ($request->hasFile('thumbnail')) {
                if ($course->thumbnail && file_exists(public_path('backend/images/courses/' . $course->thumbnail))) {
                    unlink(public_path('backend/images/courses/' . $course->thumbnail));
                }

                $image = $request->file('thumbnail');
                $imageName = 'course-' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/courses'), $imageName);
                $course->thumbnail = $imageName;
            }

            $course->save();

            return back()->with('success', 'কোর্সটি সফলভাবে আপডেট করা হয়েছে, মামা!');
        } catch (\Exception $e) {
            return back()->with('error', 'উফ! কিছু একটা সমস্যা হয়েছে: ' . $e->getMessage());
        }
    }

    public function payment()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        $payments = Payment::with('student')->get();
        return view('backend.manager-panel.history.payment-history', compact('managers', 'payments'));
    }

    public function withdrawHistory()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        $withdrawals = WithdrawRequest::with('student')->latest()->get();
        return view('backend.manager-panel.history.withdraw-history', compact('managers', 'withdrawals'));
    }

    public function subadminWithdrawHistory()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();

        $withdrawals = Withdrawal::with(['teacher', 'team_leader', 'trainer', 'helpline', 'counsellor'])
            ->latest()
            ->get();

        return view('backend.manager-panel.history.subadmin-withdraw-history', compact('managers', 'withdrawals'));
    }

    public function notice()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        $notices = Notice::latest()->get();
        return view('backend.manager-panel.notice.notice', compact('managers', 'notices'));
    }

    public function noticeCreate()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        return view('backend.manager-panel.notice.create', compact('managers'));
    }

    public function noticeStore(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'nullable|date',
        ]);

        // ২. ডাটাবেজে সেভ
        // খেয়াল করবেন আপনার মডেলের নাম 'Notice' কি না এবং কলামের নামগুলো ঠিক আছে কি না
        \App\Models\Notice::create([
            'title'       => $request->title,
            'description' => $request->description,
            'date'        => $request->date ?? now()->toDateString(),
            'status'      => $request->status,
            'created_by' => auth()->guard('subadmin')->id(),
        ]);

        // ৩. রিডাইরেক্ট
        return redirect()->route('manager.notice')->with('success', 'মামা, নোটিশটা একদম কড়কড়েভাবে সেভ হয়েছে! 🚀');
    }

    public function noticeStatus($id)
    {
        $notice = \App\Models\Notice::findOrFail($id);

        // স্ট্যাটাস ১ থাকলে ০ হবে, ০ থাকলে ১ হবে
        if ($notice->status == 1) {
            $notice->status = 0;
            $message = 'মামা, নোটিশটা আনপাবলিশ করা হয়েছে!';
        } else {
            $notice->status = 1;
            $message = 'মামা, নোটিশটা এখন লাইভ!';
        }

        $notice->save();

        return back()->with('success', $message);
    }

    public function noticeDelete($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();

        return back()->with('success', 'মামা, নোটিশটা একদম ডিলিট করে দিয়েছি! 🗑️');
    }

    public function noticeUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $notice = \App\Models\Notice::findOrFail($id);
        $notice->update([
            'title'       => $request->title,
            'description' => $request->description,
            'date'        => $request->date,
            'status'      => $request->status,
        ]);

        return back()->with('success', 'মামা, মডাল দিয়ে নোটিশ আপডেট সাকসেসফুল! 🚀');
    }

    public function contactList()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        $messages = \App\Models\Contact::orderBy('created_at', 'desc')->get();
        return view('backend.manager-panel.contact-us', compact('managers', 'messages'));
    }

    public function report(Request $request)
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $dateFilter = function ($query) use ($start_date, $end_date) {
            if ($start_date && $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            }
        };

        // ১. কাউন্টস (Cards)
        $counts = [
            'students'    => \App\Models\Student::where($dateFilter)->count(),
            'trainers'    => Trainer::count(),
            'teamleaders' => TeamLeader::count(),
            'messages'    => Contact::where($dateFilter)->count(),
            'courses'     => Course::count(),
            'teachers'    => Teacher::count(),
        ];

        // ২. আলাদা আলাদা লিস্ট (Tables)
        $students    = \App\Models\Student::where($dateFilter)->latest()->get();
        $trainers    = Trainer::latest()->get();
        $teamleaders = TeamLeader::latest()->get();
        $messages    = Contact::where($dateFilter)->latest()->get();
        $teachers    = Teacher::latest()->get();
        $counsellors = Counsellor::latest()->get();
        $helplines   = Helpline::latest()->get();

        return view('backend.manager-panel.report', compact(
            'managers',
            'counts',
            'students',
            'trainers',
            'teamleaders',
            'messages',
            'teachers',
            'counsellors',
            'helplines',
            'start_date',
            'end_date'
        ));
    }

    public function studentLock(Request $request)
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        $search = $request->input('search');

        // ২. কুয়েরি শুরু করা
        $query = Student::with('lock');

        // ৩. যদি ইউজার কিছু লিখে সার্চ করে
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('id', 'LIKE', "%{$search}%");
            });
        }

        // ৪. ডাটা গেট করা (প্যাজিনেশন চাইলে paginate(10) দিতে পারেন)
        $students = $query->latest()->get();
        return view('backend.manager-panel.student-lock', compact('managers', 'students'));
    }

    public function lockStudent($id)
    {
        Lock::updateOrCreate(
            ['student_id' => $id],
            ['is_locked' => 1]
        );

        return redirect()->back()->with('success', 'Student has been locked successfully!');
    }

    // স্টুডেন্ট আনলক করা
    public function unlockStudent($id)
    {
        $lock = Lock::where('student_id', $id)->first();

        if ($lock) {
            $lock->update(['is_locked' => 0]);
        }

        return redirect()->back()->with('success', 'Student has been unlocked successfully!');
    }

    public function profile()
    {
        $user = Auth::guard('subadmin')->user();
        $managers = Manager::where('subadmin_id', $user->id)->first();
        $manager = Manager::first();
        return view('backend.manager-panel.profile.profile', compact('managers', 'manager'));
    }

   public function updateProfile(Request $request)
{
    // ১. লগইন করা সাব-অ্যাডমিন এবং তার আন্ডারে থাকা ম্যানেজারকে ধরা
    $subadmin = auth()->user(); 
    $manager = \App\Models\Manager::where('subadmin_id', $subadmin->id)->first();

    if (!$manager) {
        return back()->with('error', 'Manager profile not found!');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // ২. সাব-অ্যাডমিন টেবিল আপডেট করা (যেখানে Name/Email থাকে)
    $subadmin->name = $request->name;
    // আপনি চাইলে ইমেইল আপডেট করার অপশন রাখলে এখানে $subadmin->email দিতে পারেন
    $subadmin->save(); 

    // ৩. ম্যানেজার টেবিল আপডেট করা (বাকি ডিটেইলস)
    $manager->name = $request->name; // দুই টেবিলই সিঙ্ক রাখার জন্য নাম এখানেও আপডেট করা ভালো
    $manager->phone = $request->phone;
    $manager->blood = $request->blood;
    $manager->facebook_link = $request->facebook_link;

    if ($request->dob) {
        $manager->dob = \Carbon\Carbon::parse($request->dob)->format('d/m/Y');
    }

    if ($request->hasFile('profile_image')) {
        if ($manager->profile_image && file_exists(public_path($manager->profile_image))) {
            unlink(public_path($manager->profile_image));
        }

        $imageName = time() . '_' . uniqid() . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path('backend/images/manager'), $imageName);

        $manager->profile_image = 'backend/images/manager/' . $imageName;
    }

    $manager->save();

    return back()->with('success', 'Profile updated successfully in both tables!');
}

    public function updatePassword(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        // ২. বর্তমান পাসওয়ার্ড চেক করা
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        // ৩. নতুন পাসওয়ার্ড আপডেট (Subadmins টেবিল)
        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        // ৪. অটো লগআউট লজিক
        auth()->logout(); // ইউজারকে সেশন থেকে বের করে দেওয়া
        $request->session()->invalidate(); // সেশন ইনভ্যালিড করা
        $request->session()->regenerateToken(); // CSRF টোকেন নতুন করে তৈরি করা

        // লগইন পেজে পাঠিয়ে দেওয়া
        return redirect()->route('subadmin.login')->with('success', 'Password changed successfully! Please login again.');
    }
}
