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
}
