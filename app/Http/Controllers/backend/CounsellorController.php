<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Counsellor;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CounsellorController extends Controller
{
    public function dashboard()
    {
        // ১. বর্তমানে লগইন করা সাব-অ্যাডমিন ইউজার
        $user = Auth::guard('subadmin')->user();

        // ২. counsellors টেবিল থেকে এই ইউজারের নির্দিষ্ট প্রোফাইলটি খুঁজে বের করা
        // এখানে 'subadmin_id' দিয়ে আমরা লিঙ্কিং করছি
        $counsellor_profile = DB::table('counsellors')->where('subadmin_id', $user->id)->first();

        // ৩. স্টুডেন্ট কাউন্ট (এখানেও প্রোফাইলের ID ব্যবহার করতে হবে)
        $total_assigned = Student::where('counsellor_id', $counsellor_profile->id)->count();
        $total_admitted = Student::where('counsellor_id', $counsellor_profile->id)->where('status', 1)->count();

        // ৪. রিসেন্ট ৫টি লিড আনা
        $recent_students = Student::where('counsellor_id', $counsellor_profile->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('backend.counsellor-panel.dashboard', [
            'counsellor' => $counsellor_profile, // আমরা প্রোফাইল ডাটা পাঠাচ্ছি
            'total_assigned' => $total_assigned,
            'total_admitted' => $total_admitted,
            'recent_students' => $recent_students
        ]);
    }

    public function leads()
    {
        // ১. প্রথমে লগইন করা সাব-অ্যাডমিনের কাউন্সেলর প্রোফাইলটা খুঁজে বের করি
        $counsellor_profile = DB::table('counsellors')
            ->where('subadmin_id', Auth::guard('subadmin')->user()->id)
            ->first();

        if (!$counsellor_profile) {
            return "মামা, আপনার তো কাউন্সেলর প্রোফাইলই সেট করা নেই!";
        }

        // ২. এবার ওই কাউন্সেলর প্রোফাইলের আইডি (১) দিয়ে স্টুডেন্টদের খুঁজবো
        $students = Student::with('course')
            ->where('counsellor_id', $counsellor_profile->id) // এখানে এখন ১ যাবে
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        // ৩. ভিউতে পাঠানোর সময় আমরা প্রোফাইল ডাটাই পাঠাবো
        $counsellor = $counsellor_profile;

        return view('backend.counsellor-panel.new-leads', compact('students', 'counsellor'));
    }

    public function updateStatus(Request $request, $id)
    {
        $counsellor_profile = DB::table('counsellors')
            ->where('subadmin_id', Auth::guard('subadmin')->user()->id)
            ->first();

        // ১. শুধুমাত্র স্টুডেন্ট আপডেট টেবিলে ডাটা ঢুকবে (হিস্ট্রি হিসেবে)
        DB::table('student_updates')->insert([
            'student_id' => $id,
            'counsellor_id' => $counsellor_profile->id,
            'status' => $request->status, // কাউন্সেলরের দেওয়া স্ট্যাটাস
            'note' => $request->note,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ২. মেইন স্টুডেন্ট টেবিলে কোনো টাচ করা হবে না (এডমিনের জন্য সেফ থাকলো)

        return back()->with('success', 'মামা, নোট সেভ হয়েছে কিন্তু মেইন স্টুডেন্ট টেবিল অপরিবর্তিত আছে! ✅');
    }

    public function activeLeads()
    {
        // ১. লগইন করা ইউজারের আইডি নেওয়া
        $authId = Auth::guard('subadmin')->id();

        // ২. counsellors টেবিল থেকে অরিজিনাল আইডি (যেমন: ১) খুঁজে বের করা
        $counsellor = DB::table('counsellors')->where('subadmin_id', $authId)->first();

        // ৩. যদি ওই কাউন্সেলর প্রোফাইল থাকে, তবেই স্টুডেন্ট খুঁজবে
        if ($counsellor) {
            $active_students = Student::where('counsellor_id', $counsellor->id) // এখানে 'id' হবে, 'subadmin_id' নয়
                ->where('status', 1) // শুধুমাত্র একটিভ স্টুডেন্ট
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
            $active_students = collect(); // প্রোফাইল না থাকলে খালি কালেকশন পাঠাবে
        }

        return view('backend.counsellor-panel.active-leads', compact('active_students', 'counsellor'));
    }

    public function myEarning()
    {
        $user = Auth::guard('subadmin')->user();
        $counsellor = DB::table('counsellors')->where('subadmin_id', $user->id)->first();

        if (!$counsellor) {
            return back()->with('error', 'প্রোফাইল পাওয়া যায়নি!');
        }

        // ৩. ট্রানজেকশন টেবিল থেকে ডাটা আনা (আসল counsellor_id দিয়ে)
        $transactions = DB::table('transactions')
            ->where('counsellor_id', $counsellor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('backend.counsellor-panel.my-earning', compact('counsellor', 'transactions'));
    }

    public function withdraw()
    {
        $user = Auth::guard('subadmin')->user();
        $counsellor = DB::table('counsellors')
            ->where('subadmin_id', $user->id)
            ->first();
        return view('backend.counsellor-panel.withdraw.withdraw', compact('counsellor'));
    }

    public function withdrawStore(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'method' => 'required',
            'account_details' => 'required',
        ]);

        $user = Auth::guard('subadmin')->user();
        $counsellor = DB::table('counsellors')->where('subadmin_id', $user->id)->first();

        // ব্যালেন্স চেক
        if ($counsellor->points < $request->amount) {
            return back()->with('error', 'মামা, আপনার অ্যাকাউন্টে পর্যাপ্ত ব্যালেন্স নেই!');
        }

        DB::table('withdrawals')->insert([
            'teacher_id'      => null,
            'team_leader_id'  => null,
            'trainer_id'      => null,
            'helpline_id'     => null,
            'counsellor_id'   => $counsellor->id,
            'amount'          => $request->amount,
            'method'          => $request->method,
            'account_details' => $request->account_details,
            'status'          => 'pending',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return back()->with('success', 'মামা, উইথড্র রিকোয়েস্ট পাঠানো হয়েছে! অ্যাডমিন চেক করে টাকা পাঠিয়ে দিবে। ✅');
    }

    public function withdrawHistory()
    {
        $user = Auth::guard('subadmin')->user();
        $counsellor = DB::table('counsellors')->where('subadmin_id', $user->id)->first();

        if (!$counsellor) {
            return back()->with('error', 'প্রোফাইল পাওয়া যায়নি!');
        }

        // ঐ নির্দিষ্ট কাউন্সেলরের সব উইথড্রাল ডাটা নিয়ে আসা
        $withdrawals = DB::table('withdrawals')
            ->where('counsellor_id', $counsellor->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backend.counsellor-panel.withdraw.history', compact('withdrawals', 'counsellor'));
    }

    public function profile()
    {
        $user = Auth::guard('subadmin')->user();
        $counsellor = DB::table('counsellors')->where('subadmin_id', $user->id)->first();
        return view('backend.counsellor-panel.profile.profile', compact('counsellor'));
    }

    public function editProfile()
    {
        $user = Auth::guard('subadmin')->user();
        $counsellor = DB::table('counsellors')->where('subadmin_id', $user->id)->first();
        return view('backend.counsellor-panel.profile.edit', compact('counsellor'));
    }

    public function updateProfile(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // ২. রিলেশনশিপের মাধ্যমে কাউন্সেলর ডাটা ধরা
        $user = Auth::guard('subadmin')->user();
        $counsellor = $user->counsellor;

        // ৩. ডাটা অ্যারে তৈরি
        $data = [
            'name'          => $request->name,
            'phone'         => $request->phone,
            'gender'        => $request->gender,
            'address'       => $request->address,
            'dob'           => $request->dob,
            'blood'         => $request->blood,
            'facebook_link' => $request->facebook_link,
            'updated_at'    => now(),
        ];

        // ৪. ইমেজ আপলোড লজিক (আপনার দেওয়া পাথ অনুযায়ী)
        if ($request->hasFile('profile_image')) {
            // আগের ইমেজ ডিলিট করার লজিক (ঐচ্ছিক কিন্তু ভালো প্র্যাকটিস)
            if ($counsellor->profile_image && file_exists(public_path('backend/images/counsellor/' . $counsellor->profile_image))) {
                unlink(public_path('backend/images/counsellor/' . $counsellor->profile_image));
            }

            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // আপনার কাঙ্ক্ষিত ফোল্ডারে সেভ করা
            $image->move(public_path('backend/images/counsellor'), $imageName);

            $data['profile_image'] = $imageName;
        }

        // ৫. ডাটাবেজ আপডেট
        DB::table('counsellors')->where('id', $counsellor->id)->update($data);

        return redirect()->route('counsellor.profile')->with('success', 'মামা, প্রোফাইল ইমেজসহ সব আপডেট হয়ে গেছে! 🚀');
    }

    public function changePassword()
    {
        $user = Auth::guard('subadmin')->user();
        $counsellor = DB::table('counsellors')->where('subadmin_id', $user->id)->first();
        return view('backend.counsellor-panel.profile.security', compact('counsellor'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::guard('subadmin')->user();

        // ১. বর্তমান পাসওয়ার্ড চেক করা
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'মামা, বর্তমান পাসওয়ার্ড তো মিললো না! ❌');
        }

        // ২. নতুন পাসওয়ার্ড সেভ করা
        DB::table('subadmins')->where('id', $user->id)->update([
            'password' => Hash::make($request->new_password),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে! 🔐');
    }
}
