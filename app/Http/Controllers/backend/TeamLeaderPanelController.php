<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TeamLeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamLeaderPanelController extends Controller
{
    public function dashboard()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();
        $studentCount = DB::table('students')->where('team_leader_id', $tl_data->id)->count();
        $totalEarnings = $tl_data->points ?? 0;

        return view('backend.team-leader-panel.dashboard', compact('tl_data', 'studentCount', 'totalEarnings'));
    }

    public function myStudents()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();

        $students = Student::with('course')->where('team_leader_id', $tl_data->id)->get();

        return view('backend.team-leader-panel.student.student-list', compact('students', 'tl_data'));
    }

    public function transactions()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();

        $transactions = DB::table('transactions')
            ->where('team_leader_id', $tl_data->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.team-leader-panel.transactions', compact('transactions', 'tl_data'));
    }

    public function withdraw()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();
        return view('backend.team-leader-panel.withdraw.withdraw', compact('tl_data'));
    }

    public function withdrawStore(Request $request)
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();

        // ব্যালেন্স চেক (যত টাকা আছে তার চেয়ে বেশি তুলতে পারবে না)
        if ($tl_data->points < $request->amount) {
            return back()->with('error', 'আপনার ব্যালেন্স পর্যাপ্ত নয়!');
        }

        // ডাটা ইনসার্ট
        DB::table('withdrawals')->insert([
            'team_leader_id'  => $tl_data->id,
            'teacher_id'      => null,
            'amount'          => $request->amount,
            'method'          => $request->method,
            'account_details' => $request->account_details, // তোমার টেবিলের কলাম নাম অনুযায়ী
            'status'          => 'pending',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect('/team-leader/withdraw-history')->with('success', 'উইথড্র রিকোয়েস্ট সফলভাবে পাঠানো হয়েছে!');
    }

    public function withdrawHistory()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();

        // উইথড্র হিস্টোরি নিয়ে আসা
        $withdraws = DB::table('withdrawals')
            ->where('team_leader_id', $tl_data->id)
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.team-leader-panel.withdraw.withdraw-history', compact('withdraws', 'tl_data'));
    }
}
