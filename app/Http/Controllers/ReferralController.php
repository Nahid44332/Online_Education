<?php

namespace App\Http\Controllers;

use App\Models\ReferralHistory;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function referral()
    {
        $student = Auth::guard('student')->user();

        $totalReferrals = Student::where('referred_by', $student->referral_code)->count();

        $referrals = Student::where('referred_by', $student->referral_code)->get();

        return view('backend.student-panel.Referral.referral', compact('student', 'totalReferrals', 'referrals'));
    }

    public function referralHistroy()
    {
        $student = Auth::guard('student')->user();
        $studentId = Auth::guard('student')->id();

        $totalPoints = ReferralHistory::where('student_id', $studentId)->sum('points');
        $totalReferrals = ReferralHistory::where('student_id', $studentId)->count();

        $histories = ReferralHistory::with('referredStudent')
            ->where('student_id', $studentId)
            ->latest()
            ->get();

        return view('backend.student-panel.Referral.referrral-history', compact('totalPoints', 'student', 'totalReferrals', 'histories'));
    }
}
