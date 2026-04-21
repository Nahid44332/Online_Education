<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CounsellorController extends Controller
{
    public function dashboard()
    {
        $counsellor = Auth::guard('subadmin')->user();
        return view('backend.counsellor-panel.dashboard', compact('counsellor'));
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
}
