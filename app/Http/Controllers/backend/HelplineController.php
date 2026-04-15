<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Helpline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HelplineController extends Controller
{
    public function dashboard()
    {
        $helpline = Auth::guard('subadmin')->user();
        $helpline_data = DB::table('helplines')->where('subadmin_id', $helpline->id)->first();
        return view('backend.helpline-panel.dashboard', compact('helpline', 'helpline_data'));
    }

    public function meeting()
    {
        return view('backend.helpline-panel.meeting');
    }

    public function UpdateMeetingDesk(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'meet_link' => 'required|url',
            'is_online' => 'required|in:0,1',
        ]);

        $subadmin_id = Auth::guard('subadmin')->user()->id;

        // ২. হেল্পলাইন টেবিলে আপডেট
        // আপনার মডেলের নাম যদি Helpline হয় তবে সেটি ইমপোর্ট করা আছে কি না দেখে নিবেন
        Helpline::where('subadmin_id', $subadmin_id)->update([
            'meet_link' => $request->meet_link,
            'is_online' => $request->is_online,
            'updated_at' => now(),
        ]);

        $notification = array(
            'message' => 'Meeting Link & Status Updated Successfully!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function EarnMoneyHistory()
    {
        // বর্তমান লগইন করা হেল্পলাইন ইউজারের আইডি নেওয়া
        $id = Auth::guard('subadmin')->user()->id;

        // ট্রানজেকশন টেবিল থেকে শুধু এই ইউজারের ডাটাগুলো আনা
        $transactions = DB::table('transactions')
            ->where('helpline_id', $id)
            ->orderBy('id', 'desc')
            ->get();

        // ভিউতে ডাটা পাঠিয়ে দেওয়া
        return view('backend.helpline-panel.earn-history', compact('transactions'));
    }

    public function WithdrawPage() {
    $id = Auth::guard('subadmin')->id();
    
    // শুধু এই ইউজারের উইথড্র রিকোয়েস্টগুলো আনা
    $withdrawals = DB::table('withdrawals')
                    ->where('helpline_id', $id)
                    ->orderBy('id', 'desc')
                    ->get();

    return view('backend.helpline-panel.withdraw', compact('withdrawals'));
}

    public function WithdrawStore(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:10',
        'method' => 'required', // Bkash, Nagad, etc.
        'account_details' => 'required',
    ]);

    $subadmin_id = Auth::guard('subadmin')->user()->id;
    
    // হেল্পলাইনের বর্তমান পয়েন্ট চেক
    $helpline = DB::table('helplines')->where('subadmin_id', $subadmin_id)->first();

    if ($helpline->points < $request->amount) {
        return back()->with('error', 'মামা, আপনার ব্যালেন্সের চেয়ে বেশি টাকা উইথড্র করতে চাচ্ছেন!');
    }

    DB::beginTransaction();
    try {
        // ১. withdrawals টেবিলে ডাটা ইনসার্ট (পেন্ডিং স্ট্যাটাস সহ)
        DB::table('withdrawals')->insert([
            'teacher_id'     => null,
            'team_leader_id' => null,
            'trainer_id'     => null,
            'helpline_id'    => $subadmin_id,
            'amount'         => $request->amount,
            'method'         => $request->method,
            'account_details' => $request->account_details,
            'status'         => 'pending', // অ্যাডমিন অ্যাপ্রুভ করলে পরে আপডেট হবে
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // ২. transactions টেবিলে হিস্টোরি রাখা (Debit হিসেবে)
        DB::table('transactions')->insert([
            'teacher_id'     => null,
            'team_leader_id' => null,
            'trainer_id'     => null,
            'helpline_id'    => $subadmin_id,
            'amount'         => $request->amount,
            'type'           => 'debit',
            'description'    => 'Withdrawal request submitted (' . $request->method . ')',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // ৩. হেল্পলাইনের মেইন পয়েন্ট থেকে টাকা কেটে রাখা
        DB::table('helplines')->where('subadmin_id', $subadmin_id)->decrement('points', $request->amount);

        DB::commit();
        return back()->with('success', 'মামা, উইথড্র রিকোয়েস্ট সাকসেসফুল! অ্যাডমিন চেক করে টাকা পাঠিয়ে দিবে।');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'ওরে মামা, এরর খাইছি: ' . $e->getMessage());
    }
}
}
