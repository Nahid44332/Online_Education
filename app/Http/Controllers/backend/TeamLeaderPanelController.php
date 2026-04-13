<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\TeamLeader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public function giftPoints(Request $request)
    {
        $request->validate([
            'student_id' => 'required',
            'points' => 'required|numeric|min:10'
        ]);

        $user = Auth::guard('subadmin')->user();
        $tl = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();

        if ($tl->points < $request->points) {
            return back()->with('error', 'মামা, আপনার তো নিজেরই মায়া দেখানোর মতো ব্যালেন্স নাই!');
        }

        // টেবিলের নাম 'users' এর জায়গায় 'students' করে দিলাম
        $student = DB::table('students')->where('id', $request->student_id)->first();

        if (!$student) {
            return back()->with('error', 'এই স্টুডেন্টকে তো খুঁজে পাওয়া যাচ্ছে না!');
        }

        DB::beginTransaction();
        try {
            // টিম লিডারের পয়েন্ট কমানো
            DB::table('team_leaders')->where('id', $tl->id)->decrement('points', $request->points);

            // স্টুডেন্টের পয়েন্ট বাড়ানো (টেবিল নাম 'students')
            DB::table('students')->where('id', $student->id)->increment('points', $request->points);

            // হিস্ট্রি রাখা
            DB::table('transactions')->insert([
                'team_leader_id' => $tl->id,
                'amount' => $request->points,
                'type' => 'debit',
                'description' => "Gifted to Student: " . $student->name,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', 'মায়া সফল হয়েছে! স্টুডেন্টকে পয়েন্ট গিফট করা হলো।');
        } catch (\Exception $e) {
            DB::rollback();
            // যদি এখনো এরর আসে, তাহলে এই নিচের লাইনটা দিয়ে চেক করো আসল ঝামেলা কী
            return back()->with('error', 'ঝামেলা: ' . $e->getMessage());
        }
    }


    //===============Trainer Create===============//

    public function trainer()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();
        $tl_id = DB::table('team_leaders')->where('subadmin_id', Auth::id())->value('id');

        $trainers = DB::table('trainers')
            ->join('subadmins', 'trainers.subadmin_id', '=', 'subadmins.id')
            ->where('trainers.team_leader_id', $tl_id)
            ->select('trainers.*', 'subadmins.email', 'subadmins.name as trainer_name')
            ->get();

        return view('backend.team-leader-panel.trainer.list', compact('trainers', 'tl_id', 'tl_data'));
    }

    public function create()
    {
        $user = Auth::guard('subadmin')->user();
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();
        return view('backend.team-leader-panel.trainer.create', compact('tl_data'));
    }

    public function store(Request $request)
    {
        $tl_id = DB::table('team_leaders')->where('subadmin_id', Auth::id())->value('id');

        // 1. Check Limit (Max 3)
        $count = DB::table('trainers')->where('team_leader_id', $tl_id)->count();
        if ($count >= 3) {
            return redirect()->route('team_leader.trainers.list')->with('error', 'Limit reached! You can only create 3 trainers.');
        }

        // 2. Validation
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:subadmins',
            'password'      => 'required|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        DB::beginTransaction();
        try {
            // 3. Handle Image Upload (If exists)
            $imageName = null;
            if ($request->hasFile('profile_image')) {
                $imageName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('backend/images/trainer'), $imageName);
            }

            // 4. Insert into Subadmins (Login Credentials)
            $subadmin_id = DB::table('subadmins')->insertGetId([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'position'   => 'trainer',
                'created_at' => now(),
            ]);

            // 5. Insert into Trainers (Profile Details)
            DB::table('trainers')->insert([
                'subadmin_id'    => $subadmin_id,
                'team_leader_id' => $tl_id,
                'name'           => $request->name,
                'phone'          => $request->phone,
                'designation'    => $request->designation,
                'dob'            => $request->dob,
                'blood'          => $request->blood,
                'facebook_link'  => $request->facebook_link,
                'profile_image'  => $imageName, // Saving the image name
                'points'         => 0, // Default 0 as per your schema
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            DB::commit();
            return redirect()->route('team_leader.trainers.list')->with('success', 'Trainer account created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            // ইমেজ আপলোড হয়ে থাকলে এবং ডাটাবেজে এরর খেলে ইমেজটা ডিলিট করে দেওয়া ভালো
            if ($imageName && file_exists(public_path('backend/images/trainer/' . $imageName))) {
                unlink(public_path('backend/images/trainer/' . $imageName));
            }
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // 1. Show the Assign Page
    public function assignPage($id)
    {
        $user = Auth::guard('subadmin')->user();
        $trainer = DB::table('trainers')->where('id', $id)->first();
        $tl_id = DB::table('team_leaders')->where('subadmin_id', Auth::id())->value('id');
        $tl_data = DB::table('team_leaders')->where('subadmin_id', $user->id)->first();

        // Get all students of this Team Leader
        $students = DB::table('students')
            ->where('team_leader_id', $tl_id)
            ->get();

        return view('backend.team-leader-panel.trainer.assign', compact('trainer', 'students', 'tl_data'));
    }

    // 2. Process the Assignment
    public function assignProcess(Request $request)
    {
        // ভ্যালিডেশন
        $request->validate([
            'trainer_id' => 'required',
            'student_id' => 'required'
        ]);

        try {
            // সিঙ্গেল স্টুডেন্ট আপডেট
            DB::table('students')
                ->where('id', $request->student_id)
                ->update([
                    'trainer_id' => $request->trainer_id,
                    'updated_at' => now()
                ]);

            return back()->with('success', 'Student assigned successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // Update Trainer
    public function update(Request $request, $id)
    {
        $trainer = DB::table('trainers')->where('id', $id)->first();

        $request->validate([
            'name' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Handle Profile Image Update
            $imageName = $trainer->profile_image; // Default to old image
            if ($request->hasFile('profile_image')) {
                // Delete old image if exists
                if ($imageName && file_exists(public_path('backend/images/trainer/' . $imageName))) {
                    unlink(public_path('backend/images/trainer/' . $imageName));
                }
                $imageName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('backend/images/trainer'), $imageName);
            }

            // 1. Update Subadmins table (Name only, email is usually kept unique/static)
            DB::table('subadmins')->where('id', $trainer->subadmin_id)->update([
                'name' => $request->name,
                'updated_at' => now(),
            ]);

            // 2. Update Trainers table
            DB::table('trainers')->where('id', $id)->update([
                'name'          => $request->name,
                'phone'         => $request->phone,
                'designation'   => $request->designation,
                'blood'         => $request->blood,
                'facebook_link' => $request->facebook_link,
                'profile_image' => $imageName,
                'updated_at'    => now(),
            ]);

            DB::commit();
            return back()->with('success', 'Trainer updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    // Delete Trainer
    public function destroy($id)
    {
        $trainer = DB::table('trainers')->where('id', $id)->first();

        if (!$trainer) {
            return back()->with('error', 'Trainer not found!');
        }

        DB::beginTransaction();
        try {
            // Delete image from folder
            if ($trainer->profile_image && file_exists(public_path('backend/images/trainer/' . $trainer->profile_image))) {
                unlink(public_path('backend/images/trainer/' . $trainer->profile_image));
            }

            // 1. Delete from subadmins (Login access gone)
            DB::table('subadmins')->where('id', $trainer->subadmin_id)->delete();

            // 2. Delete from trainers
            DB::table('trainers')->where('id', $id)->delete();

            // 3. Unassign students (Trainer ID null করে দেওয়া যাতে স্টুডেন্ট ডিলিট না হয়)
            DB::table('students')->where('trainer_id', $id)->update(['trainer_id' => null]);

            DB::commit();
            return back()->with('success', 'Trainer and their access removed successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}
