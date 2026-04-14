<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TrainerPanelController extends Controller
{
    public function dashboard()
    {
        $trainer = Auth::guard('subadmin')->user();
        $tr_data = DB::table('trainers')->where('subadmin_id', $trainer->id)->first();
        $totalStudents = DB::table('students')->where('trainer_id', $tr_data->id)->count();
        $totalEarnings = $tr_data->points ?? 0;
        return view('backend.trainer-panel.dashboard', compact('trainer', 'tr_data', 'totalStudents', 'totalEarnings'));
    }

    public function studentList()
    {
        $subadmin = Auth::guard('subadmin')->user();
        $trainer = DB::table('trainers')->where('subadmin_id', $subadmin->id)->first();
        $students = Student::with('course') // 'course' হলো তোমার Student মডেলে থাকা রিলেশন মেথড
            ->where('trainer_id', $trainer->id)
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.trainer-panel.student-list', compact('students'));
    }

    public function profile()
    {
        $subadmin = Auth::guard('subadmin')->user();
        // রিলেশনশিপ ব্যবহার করে ট্রেইনারের সব ডাটা নিয়ে আসা
        $trainer = Trainer::where('subadmin_id', $subadmin->id)->first();

        return view('backend.trainer-panel.profile', compact('subadmin', 'trainer'));
    }

    // এডিট পেজ দেখানোর জন্য
    public function profileEdit()
    {
        $subadmin = Auth::guard('subadmin')->user();
        $trainer = DB::table('trainers')->where('subadmin_id', $subadmin->id)->first();
        return view('backend.trainer-panel.profile-edit', compact('subadmin', 'trainer'));
    }

    // ডাটা আপডেট করার জন্য
    public function profileUpdate(Request $request)
    {
        $subadmin = Auth::guard('subadmin')->user();
        $trainer = DB::table('trainers')->where('subadmin_id', $subadmin->id)->first();

        // ভ্যালিডেশন
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // ১. সাব-অ্যাডমিন টেবিল আপডেট (নাম)
        DB::table('subadmins')->where('id', $subadmin->id)->update([
            'name' => $request->name,
        ]);

        // ২. ট্রেইনার টেবিল আপডেট
        $data = [
            'phone' => $request->phone,
            'dob' => $request->dob,
            'blood' => $request->blood,
            'facebook_link' => $request->facebook_link,
        ];

        // ইমেজ আপলোড লজিক
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('backend/images/trainer'), $imageName);
            $data['profile_image'] = $imageName;
        }

        DB::table('trainers')->where('subadmin_id', $subadmin->id)->update($data);

        return redirect()->route('trainer.profile')->with('success', 'Profile updated successfully!');
    }

    public function changePassword()
    {
        return view('backend.trainer-panel.change-password');
    }

    // পাসওয়ার্ড আপডেট করা
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // 'confirmed' মানে new_password_confirmation এর সাথে মিলতে হবে
        ]);

        $user = Auth::guard('subadmin')->user();

        // ১. বর্তমান পাসওয়ার্ড চেক
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'বর্তমান পাসওয়ার্ডটি সঠিক নয়!');
        }

        // ২. নতুন পাসওয়ার্ড সেভ করা
        DB::table('subadmins')->where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে!');
    }

    public function withdraw()
{
    // ১. লগইন করা সাবএডমিনের ডাটা আনা
    $user = Auth::guard('subadmin')->user();

    // ২. ট্রেইনার টেবিল থেকে তার বর্তমান পয়েন্ট নিয়ে আসা
    // এখানে ভেরিয়েবল নাম $trainer
    $trainer = DB::table('trainers')->where('subadmin_id', $user->id)->first();

    // এখানে ভুল ছিল: $tr_data এর বদলে $trainer হবে
    $current_points = $trainer->points ?? 0; 

    // ৩. এই ট্রেইনারের আগের উইথড্র হিস্ট্রি আনা
    $withdrawals = DB::table('withdrawals')
        ->where('trainer_id', $trainer->id)
        ->orderBy('id', 'desc')
        ->get();

    // ৪. ভিউতে ডাটাগুলো পাঠিয়ে দেওয়া
    return view('backend.trainer-panel.withdraw', compact('current_points', 'withdrawals'));
}

    public function withdrawStore(Request $request)
    {
        // ভ্যালিডেশন
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'method' => 'required',
            'account_details' => 'required',
        ]);

        // লগইন করা সাবএডমিন ইউজার
        $user = Auth::guard('subadmin')->user();

        // ট্রেইনারস টেবিল থেকে ডাটা আনা (যেখানে subadmin_id ম্যাচ করে)
        $trainer_data = DB::table('trainers')->where('subadmin_id', $user->id)->first();

        // ব্যালেন্স চেক
        if (!$trainer_data || $trainer_data->points < $request->amount) {
            return back()->with('error', 'আপনার ব্যালেন্স পর্যাপ্ত নয় বা ট্রেইনার প্রোফাইল পাওয়া যায়নি!');
        }

        // ডাটা ইনসার্ট
        DB::table('withdrawals')->insert([
            'trainer_id'      => $trainer_data->id,
            'amount'          => $request->amount,
            'method'          => $request->method,
            'account_details' => $request->account_details,
            'status'          => 'pending',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->back()->with('success', 'উইথড্র রিকোয়েস্ট সফলভাবে পাঠানো হয়েছে!');
    }
}
