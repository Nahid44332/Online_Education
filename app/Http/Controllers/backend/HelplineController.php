<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Helpline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function WithdrawPage()
    {
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

    public function HelplineProfile()
    {
        $id = Auth::guard('subadmin')->id();
        $data = DB::table('helplines')->where('subadmin_id', $id)->first();
        return view('backend.helpline-panel.profile', compact('data'));
    }

    public function HelplineProfileUpdate(Request $request)
    {
        $subadmin_id = Auth::guard('subadmin')->id();

        $data = array();
        $data['name'] = $request->name;
        $data['phone'] = $request->phone;
        $data['address'] = $request->address;
        $data['blood'] = $request->blood;
        $data['shift'] = $request->shift;
        $data['updated_at'] = now();

        // ইমেজ আপলোড লজিক
        if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('backend/images/helpline'), $filename);
            $data['image'] = 'backend/images/helpline/' . $filename;
        }

        DB::table('helplines')->where('subadmin_id', $subadmin_id)->update($data);

        // subadmins টেবিলের নামও আপডেট করে দেওয়া ভালো
        DB::table('subadmins')->where('id', $subadmin_id)->update(['name' => $request->name]);

        return back()->with('success', 'মামা, প্রোফাইল একদম ঝকঝকে হয়ে আপডেট হইছে!');
    }

    public function ChangePassword()
    {
        return view('backend.helpline-panel.change_password');
    }

    public function HelplinePasswordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ], [
            'confirm_password.same' => 'মামা, নতুন পাসওয়ার্ড দুইবার দুইরকম হয়ে গেছে!',
            'new_password.min' => 'নতুন পাসওয়ার্ড অন্তত ৮ অক্ষরের হতে হবে।'
        ]);

        $hashedPassword = Auth::guard('subadmin')->user()->password;

        // পুরাতন পাসওয়ার্ড চেক
        if (Hash::check($request->old_password, $hashedPassword)) {
            $id = Auth::guard('subadmin')->id();

            DB::table('subadmins')->where('id', $id)->update([
                'password' => Hash::make($request->new_password),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'মামা, পাসওয়ার্ড একদম বদলে গেছে! সাবধানে মনে রাইখেন।');
        } else {
            return back()->with('error', 'মামা, পুরাতন পাসওয়ার্ড তো ঠিক দিলেন না!');
        }
    }
}
