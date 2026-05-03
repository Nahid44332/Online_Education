<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Helpline;
use App\Models\Manager;
use App\Models\Student;
use App\Models\Subadmin;
use App\Models\TeamLeader;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\Cast\Void_;
use Spatie\FlareClient\View;

use function Ramsey\Uuid\v1;

class SubadminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function teamLeader()
    {
        $team_leaders = TeamLeader::with('subadmin')->orderBy('id', 'desc')->get();
        return view('backend.team-leader.team-leader-list', compact('team_leaders'));
    }

    public function storeTeamLeader(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subadmins',
            'password' => 'required|min:6',
            'name' => 'required',
        ]);

        // subadmins টেবিলে সেভ
        $subadmin = new Subadmin();
        $subadmin->name = $request->name;
        $subadmin->email = $request->email;
        $subadmin->password = Hash::make($request->password);
        $subadmin->position = 'team_leader';
        $subadmin->save();

        // team_leaders টেবিলে সেভ
        $tl = new TeamLeader();
        $tl->subadmin_id = $subadmin->id;
        $tl->name = $request->name;
        $tl->designation = $request->designation;
        $tl->phone = $request->phone;
        $tl->dob = $request->dob;
        $tl->blood = $request->blood;
        $tl->facebook_link = $request->facebook_link;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/team-leader'), $filename);
            $tl->profile_image = $filename;
        }

        $tl->save();

        return redirect()->back()->with('success', 'Team Leader added successfully!');
    }

    public function deleteTeamLeader($id)
    {
        $tl = TeamLeader::findOrFail($id);

        // ১. ফোল্ডার থেকে ছবি ডিলিট করা
        if ($tl->profile_image) {
            $imagePath = public_path('backend/images/team-leader/' . $tl->profile_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // ২. subadmins টেবিল থেকে ডাটা ডিলিট করা (যেহেতু foreign key থাকতে পারে)
        $subadmin = Subadmin::find($tl->subadmin_id);
        if ($subadmin) {
            $subadmin->delete();
        }

        // ৩. team_leaders টেবিল থেকে ডিলিট
        $tl->delete();

        return back()->with('success', 'Team Leader and associated login account deleted!');
    }

    public function updateTeamLeader(Request $request, $id)
    {
        $tl = TeamLeader::findOrFail($id);

        // ১. টিম লিডার ডাটা আপডেট
        $tl->name = $request->name;
        $tl->designation = $request->designation;
        $tl->phone = $request->phone;
        $tl->blood = $request->blood;

        // ২. সাবএডমিন টেবিলে নাম আপডেট
        $subadmin = Subadmin::find($tl->subadmin_id);
        if ($subadmin) {
            $subadmin->name = $request->name;
            $subadmin->save();
        }

        // ৩. নতুন ইমেজ আপলোড এবং পুরাতনটি ডিলিট
        if ($request->hasFile('profile_image')) {
            // পুরাতন ইমেজ ডিলিট
            if ($tl->profile_image) {
                $oldPath = public_path('backend/images/team-leader/' . $tl->profile_image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('backend/images/team-leader/'), $filename);
            $tl->profile_image = $filename;
        }

        $tl->save();

        return back()->with('success', 'Team Leader updated successfully!');
    }

    public function assignStudentPage($id)
    {
        $team_leader = DB::table('team_leaders')->where('id', $id)->first();

        // শুধু সেই স্টুডেন্টদের আনো যাদের এখনো কোনো টিম লিডার নাই (team_leader_id = 0 বা null)
        $students = DB::table('students')->where('team_leader_id', 0)->get();

        return view('backend.team-leader.assign_view', compact('team_leader', 'students'));
    }

    public function confirmAssign($tl_id, $student_id)
    {
        // ১. স্টুডেন্ট খুঁজে বের করা
        $student = DB::table('students')->where('id', $student_id)->first();

        if ($student) {
            // ২. টিম লিডার আইডি আপডেট করা
            DB::table('students')->where('id', $student_id)->update([
                'team_leader_id' => $tl_id
            ]);

            return redirect()->back()->with('success', 'Student assigned successfully!');
        }

        return redirect()->back()->with('error', 'Student not found!');
    }

    public function addTlPoints(Request $request)
    {
        $tl = DB::table('team_leaders')->where('id', $request->tl_id);
        $currentTl = $tl->first();

        if ($currentTl) {
            $newPoints = $currentTl->points + $request->points;

            // ১. মেইন পয়েন্ট আপডেট
            $tl->update(['points' => $newPoints]);

            // ২. ট্রানজেকশন টেবিলে ডাটা ইনসার্ট (এটা মিসিং ছিল)
            DB::table('transactions')->insert([
                'team_leader_id' => $request->tl_id,
                'teacher_id'     => null, // টিচার আইডি নাল থাকবে
                'amount'         => $request->points,
                'type'           => 'credit',
                'description'    => 'Admin added balance',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return back()->with('success', 'Points added and recorded successfully!');
        }

        return back()->with('error', 'Team Leader not found!');
    }

    public function withdrawRequests()
    {
        $requests = DB::table('withdrawals')
            ->whereNotNull('team_leader_id') // শুধু টিম লিডারদের রিকোয়েস্ট
            ->orderBy('id', 'desc')
            ->get();

        return view('backend.subadmin-withdraw.team-leader-withdraw', compact('requests'));
    }

    public function approveWithdraw($id)
    {
        $withdraw = DB::table('withdrawals')->where('id', $id)->first();

        if ($withdraw && $withdraw->status == 'pending') {
            $tl = DB::table('team_leaders')->where('id', $withdraw->team_leader_id)->first();

            if ($tl->points < $withdraw->amount) {
                return back()->with('error', 'টিম লিডারের ব্যালেন্স পর্যাপ্ত নয়!');
            }
            DB::table('withdrawals')->where('id', $id)->update([
                'status' => 'approved',
                'updated_at' => now()
            ]);

            DB::table('team_leaders')->where('id', $withdraw->team_leader_id)->decrement('points', $withdraw->amount);
            DB::table('transactions')->insert([
                'team_leader_id' => $withdraw->team_leader_id,
                'amount'         => $withdraw->amount,
                'type'           => 'debit', // টাকা কমে যাওয়া মানে ডেবিট
                'description'    => 'উইথড্র এপ্রুভ করা হয়েছে (' . $withdraw->method . ')',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return back()->with('success', 'উইথড্র রিকোয়েস্ট এপ্রুভ হয়েছে এবং ব্যালেন্স কেটে নেওয়া হয়েছে!');
        }

        return back()->with('error', 'রিকোয়েস্টটি খুঁজে পাওয়া যায়নি বা অলরেডি এপ্রুভড!');
    }

    //=============Trainer====================//

    public function trainer()
    {
        $trainers = Trainer::with('subadmin')->orderBy('id', 'desc')->get();
        return view('backend.trainer.trainer-list', compact('trainers'));
    }

    public function addTrainerPoints(Request $request)
    {
        // ১. সরাসরি ট্রেইনার কুয়েরি
        $trainerQuery = DB::table('trainers')->where('id', $request->trainer_id);
        $currentTrainer = $trainerQuery->first();

        if ($currentTrainer) {
            $newPoints = $currentTrainer->points + $request->amount;

            // ২. ট্রেইনারের মেইন পয়েন্ট আপডেট
            $trainerQuery->update(['points' => $newPoints]);

            // ৩. ট্রানজেকশন টেবিলে নতুন trainer_id কলামে ডাটা ইনসার্ট
            DB::table('transactions')->insert([
                'teacher_id'     => null,
                'team_leader_id' => null,
                'trainer_id'     => $request->trainer_id, // এবার আসল আইডিতেই বাড়ি!
                'amount'         => $request->amount,
                'type'           => 'credit',
                'description'    => 'Admin added salary/points',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);

            return back()->with('success', 'Trainer wallet updated and recorded!');
        }

        return back()->with('error', 'Trainer not found!');
    }

    public function trainerwithdrawRequests()
    {
        $requests = DB::table('withdrawals')
            ->whereNotNull('trainer_id')
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.subadmin-withdraw.trainer-withdraw', compact('requests'));
    }

    public function approveTrainerWithdraw($id)
    {
        $withdraw = DB::table('withdrawals')->where('id', $id)->first();

        if (!$withdraw) {
            return back()->with('error', 'উইথড্র রিকোয়েস্ট পাওয়া যায়নি!');
        }

        // ট্রেইনারের ব্যালেন্স আপডেট এবং স্ট্যাটাস চেঞ্জ
        DB::beginTransaction();
        try {
            // ১. ট্রেইনারের পয়েন্ট কমানো
            DB::table('trainers')->where('id', $withdraw->trainer_id)->decrement('points', $withdraw->amount);

            // ২. স্ট্যাটাস এপ্রুভ করা
            DB::table('withdrawals')->where('id', $id)->update([
                'status' => 'approved',
                'updated_at' => now()
            ]);

            DB::commit();
            return back()->with('success', 'ট্রেইনারের উইথড্র সফলভাবে এপ্রুভ হয়েছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'কিছু একটা ভুল হয়েছে!');
        }
    }

    //============Helpline==============//

    public function helpline()
    {
        $staffs = Subadmin::where('position', 'helpline')->with('helpline')->latest()->get();
        return view('backend.helpline.helpline', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:subadmins,email',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // ২ এমবি লিমিট
        ]);

        DB::beginTransaction();
        try {
            // ১. সাব-এডমিন তৈরি
            $subadmin = \App\Models\Subadmin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'position' => 'helpline',
                'status' => 1,
            ]);

            // ২. আপনার দেওয়া পাথে ইমেজ হ্যান্ডেলিং
            $save_url = null;
            if ($request->file('image')) {
                $image = $request->file('image');
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

                // আপনার কাঙ্ক্ষিত পাথ: backend/images/helpline/
                $image->move(public_path('backend/images/helpline/'), $name_gen);
                $save_url = 'backend/images/helpline/' . $name_gen;
            }

            // ৩. হেল্পলাইন ডিটেইলস সেভ
            \App\Models\Helpline::create([
                'subadmin_id' => $subadmin->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'blood' => $request->blood,
                'shift' => $request->shift,
                'image' => $save_url,
            ]);

            DB::commit();
            return back()->with('success', 'Helpline Account Created Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        Subadmin::findOrFail($id)->delete();
        return back()->with('success', 'helpline Deleted Successfully!');
    }

    // এডিট ডাটা ফেচ করা (AJAX বা সরাসরি আইডি দিয়ে)
    public function edit($id)
    {
        $staff = Subadmin::with('helpline')->findOrFail($id);
        return response()->json($staff);
    }

    // আপডেট লজিক
    public function update(Request $request)
    {
        $id = $request->id;
        $subadmin = Subadmin::findOrFail($id);
        $helpline = Helpline::where('subadmin_id', $id)->first();

        DB::beginTransaction();
        try {
            // ১. সাব-এডমিন আপডেট
            $subadmin->update([
                'name' => $request->name,
                'email' => $request->email,
                // পাসওয়ার্ড ইনপুট দিলে আপডেট হবে, না দিলে আগেরটাই থাকবে
                'password' => $request->password ? Hash::make($request->password) : $subadmin->password,
            ]);

            // ২. ইমেজ আপডেট লজিক
            $save_url = $helpline->image;
            if ($request->file('image')) {
                $image = $request->file('image');
                if ($helpline->image && file_exists(public_path($helpline->image))) {
                    unlink(public_path($helpline->image)); // আগের ফাইল ডিলিট
                }
                $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/helpline/'), $name_gen);
                $save_url = 'backend/images/helpline/' . $name_gen;
            }

            // ৩. হেল্পলাইন টেবিল আপডেট
            $helpline->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'blood' => $request->blood,
                'shift' => $request->shift,
                'image' => $save_url,
            ]);

            DB::commit();
            return back()->with('success', 'Staff Updated Successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function AddHelplinePoints(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'subadmin_id' => 'required'
        ]);

        // ১. হেল্পলাইন টেবিলে পয়েন্ট যোগ করা
        Helpline::where('subadmin_id', $request->subadmin_id)->increment('points', $request->amount);

        // ২. ট্রানজেকশন টেবিলে ডাটা ইনসার্ট করা (যাতে হিস্টোরিতে দেখা যায়)
        DB::table('transactions')->insert([
            'teacher_id'     => null,
            'team_leader_id' => null,
            'trainer_id'     => null,
            'helpline_id'    => $request->subadmin_id, // আপনার নতুন বানানো কলাম
            'amount'         => $request->amount,
            'type'           => 'credit',
            'description'    => 'Admin added salary',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return back()->with('success', 'পয়েন্ট সফলভাবে অ্যাড হয়েছে এবং ট্রানজেকশন রেকর্ড করা হয়েছে, মামা!');
    }

    public function helplineWithdrawRequests()
    {
        $requests = DB::table('withdrawals')
            ->whereNotNull('helpline_id') // যাদের হেল্পলাইন আইডি আছে শুধু তাদের ডাটা
            ->orderBy('id', 'desc')
            ->get();
        return view('backend.subadmin-withdraw.helpline-withdraw', compact('requests'));
    }

    public function ApproveWithdrawHelpline($id)
    {
        $withdraw = DB::table('withdrawals')->where('id', $id)->first();

        if ($withdraw && $withdraw->status == 'pending') {
            DB::beginTransaction();
            try {
                // ১. উইথড্রাল স্ট্যাটাস আপডেট
                DB::table('withdrawals')->where('id', $id)->update([
                    'status' => 'approved',
                    'updated_at' => now()
                ]);

                // ২. ট্রানজেকশন টেবিলে রেকর্ড আপডেট বা নতুন এন্ট্রি (ঐচ্ছিক কিন্তু ভালো প্র্যাকটিস)
                // আপনি যদি চান উইথড্র হওয়ার সময় ডেসক্রিপশন আপডেট হোক:
                DB::table('transactions')
                    ->where('helpline_id', $withdraw->helpline_id)
                    ->where('amount', $withdraw->amount)
                    ->where('type', 'debit')
                    ->where('description', 'like', '%Withdrawal request submitted%')
                    ->latest()
                    ->update([
                        'description' => 'Withdrawal approved (Method: ' . $withdraw->method . ')',
                        'updated_at' => now()
                    ]);

                DB::commit();
                return back()->with('success', 'মামা, উইথড্র অ্যাপ্রুভ হইছে! টাকা পাঠাইয়া দেন।');
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'ঝামেলা হইছে মামা: ' . $e->getMessage());
            }
        }

        return back()->with('error', 'এই রিকোয়েস্ট অলরেডি প্রসেস করা হইছে।');
    }

    public function RejectWithdraw($id)
    {
        $withdraw = DB::table('withdrawals')->where('id', $id)->first();

        if ($withdraw->status == 'pending') {
            // ১. হেল্পলাইনকে তার টাকা ফেরত দেওয়া (যেহেতু রিজেক্ট হইছে)
            DB::table('helplines')->where('subadmin_id', $withdraw->helpline_id)->increment('points', $withdraw->amount);

            // ২. ট্রানজেকশন টেবিলে একটা রিফান্ড এন্ট্রি দেওয়া (Credit)
            DB::table('transactions')->insert([
                'helpline_id' => $withdraw->helpline_id,
                'amount'      => $withdraw->amount,
                'type'        => 'credit',
                'description' => 'Withdrawal Rejected (Refunded)',
                'created_at'  => now()
            ]);

            // ৩. স্ট্যাটাস রিজেক্ট করা
            DB::table('withdrawals')->where('id', $id)->update(['status' => 'rejected', 'updated_at' => now()]);

            return back()->with('success', 'রিকোয়েস্ট রিজেক্ট হইছে এবং টাকা ফেরত গেছে।');
        }
        return back()->with('error', 'এই রিকোয়েস্ট অলরেডি প্রসেস করা হইছে।');
    }

    //===========Counsellor==================//

    public function counsellor()
    {
        $counsellors = DB::table('counsellors')
            ->join('subadmins', 'counsellors.subadmin_id', '=', 'subadmins.id')
            ->select('counsellors.*', 'subadmins.email')
            ->orderBy('counsellors.id', 'desc')
            ->get();
        return view('backend.counsellor.Counsellor', compact('counsellors'));
    }

    public function counsellorCreate()
    {
        return view('backend.Counsellor.create');
    }
    public function counsellorStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:subadmins',
            'password' => 'required|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            // ইমেজ আপলোড লজিক (আপনার নতুন পাথ অনুযায়ী)
            $imageName = null;
            if ($request->hasFile('profile_image')) {
                $imageName = time() . '.' . $request->profile_image->extension();
                // এখানে পাথ পরিবর্তন করা হয়েছে
                $request->profile_image->move(public_path('backend/images/counsellor'), $imageName);
            }

            $subadmin_id = DB::table('subadmins')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'position' => 'counsellor',
                'created_at' => now(),
            ]);

            DB::table('counsellors')->insert([
                'subadmin_id' => $subadmin_id,
                'name' => $request->name,
                'designation' => $request->designation,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'blood' => $request->blood,
                'address' => $request->address,
                'facebook_link' => $request->facebook_link,
                'dob' => $request->dob,
                'profile_image' => $imageName,
                'status' => $request->status ?? 1,
                'created_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('admin.counsellor')->with('success', 'মামা, কাউন্সেলর আইডি তৈরি হয়ে গেছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'ঝামেলা হইছে মামা: ' . $e->getMessage());
        }
    }

    // ১. আপডেট কন্ট্রোলার
    public function counsellorUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $counsellor = DB::table('counsellors')->where('id', $id)->first();

            // ইমেজ হ্যান্ডেলিং
            $imageName = $counsellor->profile_image;
            if ($request->hasFile('profile_image')) {
                // পুরনো ইমেজ ডিলিট
                if ($imageName) {
                    $oldPath = public_path('backend/images/counsellor/' . $imageName);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                // নতুন ইমেজ সেভ
                $imageName = time() . '.' . $request->profile_image->extension();
                $request->profile_image->move(public_path('backend/images/counsellor'), $imageName);
            }

            // সাব-এডমিন টেবিল আপডেট (নাম আপডেট হতে পারে)
            DB::table('subadmins')->where('id', $counsellor->subadmin_id)->update([
                'name' => $request->name,
                'updated_at' => now(),
            ]);

            // কাউন্সেলর টেবিল আপডেট
            DB::table('counsellors')->where('id', $id)->update([
                'name' => $request->name,
                'designation' => $request->designation,
                'phone' => $request->phone,
                'profile_image' => $imageName,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

            DB::commit();
            return back()->with('success', 'মামা, কাউন্সেলর ডাটা আপডেট হয়ে গেছে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'ঝামেলা হইছে মামা: ' . $e->getMessage());
        }
    }

    // ২. ডিলিট কন্ট্রোলার
    public function counsellorDelete($id)
    {
        try {
            DB::beginTransaction();

            $counsellor = DB::table('counsellors')->where('id', $id)->first();

            if ($counsellor) {
                // ১. ইমেজ ডিলিট
                if ($counsellor->profile_image) {
                    $imagePath = public_path('backend/images/counsellor/' . $counsellor->profile_image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                // ২. সাব-এডমিন ডিলিট (এটা ডিলিট করলে রিলেশন অনুযায়ী কাউন্সেলরও যাবে, তবে আমরা ম্যানুয়ালি করছি সেফটির জন্য)
                DB::table('subadmins')->where('id', $counsellor->subadmin_id)->delete();
                DB::table('counsellors')->where('id', $id)->delete();

                DB::commit();
                return back()->with('success', 'মামা, কাউন্সেলরকে বিদায় করে দেওয়া হয়েছে!');
            }

            return back()->with('error', 'মামা, কাউরে তো পাইলাম না ডিলিট করতে!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'ডিলিট করতে গিয়ে এরর: ' . $e->getMessage());
        }
    }

    public function assignStudentList($counsellor_id)
    {
        $counsellor = DB::table('counsellors')->where('id', $counsellor_id)->first();
        $unassigned_students = Student::with('course')
            ->whereNull('counsellor_id')
            ->where('status', 0)
            ->get();

        return view('backend.counsellor.assign_student_list', compact('counsellor', 'unassigned_students'));
    }

    public function assignProcess($counsellor_id, $student_id)
    {
        DB::table('students')->where('id', $student_id)->update([
            'counsellor_id' => $counsellor_id,
            'updated_at' => now()
        ]);

        return back()->with('success', 'মামা, স্টুডেন্টকে সফলভাবে কাউন্সেলরের আন্ডারে দেওয়া হয়েছে!');
    }

    public function getCounsellorLogs($id)
    {
        // ওই কাউন্সেলরের আন্ডারে থাকা স্টুডেন্টদের সব আপডেট নোটসহ নিয়ে আসা
        $logs = DB::table('student_updates')
            ->join('students', 'student_updates.student_id', '=', 'students.id')
            ->where('student_updates.counsellor_id', $id)
            ->select('student_updates.*', 'students.name as student_name')
            ->orderBy('student_updates.created_at', 'desc')
            ->get();

        return response()->json($logs);
    }

    public function addCounsellorPoints(Request $request)
    {
        $request->validate([
            'counsellor_id' => 'required',
            'points' => 'required|numeric'
        ]);

        // বর্তমান পয়েন্টের সাথে নতুন অ্যামাউন্ট যোগ করা
        $counsellor = DB::table('counsellors')->where('id', $request->counsellor_id);
        $currentPoints = $counsellor->first()->points ?? 0;

        $counsellor->update([
            'points' => $currentPoints + $request->points
        ]);

        DB::table('transactions')->insert([
            'teacher_id'     => null,
            'team_leader_id'     => null,
            'trainer_id'     => null,
            'helpline_id'     => null,
            'counsellor_id'  => $request->counsellor_id, // এখানে $request থেকে নিতে হবে
            'amount'         => $request->points,
            'type'           => 'credit', // যেহেতু টাকা জমা হচ্ছে
            'description'    => $request->description ?? 'Admin added points',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
        return back()->with('success', 'মামা, কাউন্সেলরের অ্যাকাউন্টে টাকা/পয়েন্ট যোগ হয়েছে! ✅');
    }

    public function counsellorWithdrawRequest()
    {
        $requests = DB::table('withdrawals')
            ->whereNotNull('counsellor_id') // শুধুমাত্র কাউন্সেলরদের ডাটা ফিল্টার
            ->orderBy('created_at', 'desc')
            ->get();
        return view('backend.subadmin-withdraw.counsellor-withdraw', compact('requests'));
    }

    public function approveCounsellorWithdraw($id)
    {
        $withdraw = DB::table('withdrawals')->where('id', $id)->first();

        if (!$withdraw || $withdraw->status !== 'pending') {
            return back()->with('error', 'রিকোয়েস্টটি পাওয়া যায়নি বা অলরেডি প্রসেস করা হয়েছে।');
        }

        $counsellor = DB::table('counsellors')->where('id', $withdraw->counsellor_id)->first();

        if ($counsellor->points < $withdraw->amount) {
            return back()->with('error', 'কাউন্সেলরের পর্যাপ্ত ব্যালেন্স নেই!');
        }

        // ট্রানজেকশনটি একটি ডাটাবেজ ট্রানজেকশনের ভেতরে রাখা ভালো
        DB::transaction(function () use ($withdraw, $counsellor) {
            // ক. কাউন্সেলরের পয়েন্ট কমানো
            DB::table('counsellors')->where('id', $withdraw->counsellor_id)->update([
                'points' => $counsellor->points - $withdraw->amount,
                'updated_at' => now()
            ]);

            // খ. ট্রানজেকশন টেবিলে ডেবিট এন্ট্রি দেওয়া
            DB::table('transactions')->insert([
                'counsellor_id' => $withdraw->counsellor_id,
                'amount'        => $withdraw->amount,
                'type'          => 'debit',
                'description'   => "Withdrawal approved (Method: {$withdraw->method})",
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // গ. উইথড্রয়াল স্ট্যাটাস আপডেট করা
            DB::table('withdrawals')->where('id', $withdraw->id)->update([
                'status' => 'approved',
                'updated_at' => now()
            ]);
        });

        return back()->with('success', 'পেমেন্ট এপ্রুভ করা হয়েছে এবং ব্যালেন্স অ্যাডজাস্ট হয়েছে। ✅');
    }

    // ৩. রিকোয়েস্ট রিজেক্ট করা
    public function rejectCounsellorWithdraw($id)
    {
        DB::table('withdrawals')->where('id', $id)->update([
            'status' => 'rejected',
            'updated_at' => now()
        ]);

        return back()->with('error', 'রিকোয়েস্টটি রিজেক্ট করা হয়েছে।');
    }

    //==========Manager================//
    public function manager()
    {
       $managers = Manager::with('subadmin')->orderBy('id', 'desc')->get();
        return view('backend.manager.manager', compact('managers'));
    }

    public function managerStore(Request $request)
    {
        // ১. subadmins টেবিলে লগইন ডেটা সেভ
        $subadmin = new Subadmin();
        $subadmin->name = $request->name;
        $subadmin->email = $request->email;
        $subadmin->password = Hash::make($request->password);
        $subadmin->position = 'manager';
        $subadmin->status = 1;
        $subadmin->save();

        // ২. managers টেবিলে পার্সোনাল ডেটা সেভ
        $manager = new Manager();
        $manager->subadmin_id = $subadmin->id;
        $manager->name = $request->name;
        $manager->designation = $request->designation;
        $manager->phone = $request->phone;
        $manager->dob = $request->dob; // Date of Birth
        $manager->blood = $request->blood;
        $manager->facebook_link = $request->facebook_link;

        if ($request->file('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/images/manager'), $filename);
            $manager->profile_image = 'backend/images/manager/' . $filename;
        }

        $manager->save();
        return back()->with('success', 'ম্যানেজার মামাকে সফলভাবে নিয়োগ দেওয়া হয়েছে! ✅');
    }

    public function managerEdit($id)
    {
        $manager = Manager::with('subadmin')->findOrFail($id);
        return response()->json([
            'id' => $manager->id,
            'name' => $manager->name,
            'email' => $manager->subadmin->email, // সাবএডমিন টেবিল থেকে ইমেইল
            'designation' => $manager->designation,
            'phone' => $manager->phone,
            'dob' => $manager->dob,
            'blood' => $manager->blood,
            'facebook_link' => $manager->facebook_link,
        ]);
    }

    public function managerUpdate(Request $request)
    {
        $manager = Manager::findOrFail($request->id);

        // ১. সাবএডমিন টেবিলে নাম ও ইমেইল আপডেট
        $subadmin = Subadmin::find($manager->subadmin_id);
        if ($subadmin) {
            $subadmin->name = $request->name;
            $subadmin->email = $request->email;
            $subadmin->save();
        }

        // ২. ম্যানেজার টেবিলে ডাটা আপডেট
        $manager->name = $request->name;
        $manager->designation = $request->designation;
        $manager->phone = $request->phone;
        $manager->dob = $request->dob;
        $manager->blood = $request->blood;
        $manager->facebook_link = $request->facebook_link;

        if ($request->file('image')) {
            // পুরাতন ইমেজ ডিলিট
            if ($manager->profile_image && file_exists(public_path($manager->profile_image))) {
                unlink(public_path($manager->profile_image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('backend/images/manager'), $filename);
            $manager->profile_image = 'backend/images/manager/' . $filename;
        }

        $manager->save();
        return back()->with('success', 'ম্যানেজারের তথ্য আপডেট হয়েছে! 🔄');
    }

    public function destroy($id) {
        $manager = DB::table('managers')->where('id', $id)->first();
        if($manager->profile_image) unlink(public_path($manager->profile_image));
        DB::table('managers')->where('id', $id)->delete();
        return back()->with('success', 'ম্যানেজার বিদায় নিয়েছে! 🗑️');
    }

    public function addManagerPoints(Request $request)
{
   $request->validate([
        'subadmin_id' => 'required',
        'amount' => 'required|numeric' // এখানে min:1 রাখা যাবে না
    ]);

    // সরাসরি managers টেবিল থেকে ডাটা বের করা
    $manager = \Illuminate\Support\Facades\DB::table('managers')
                ->where('id', $request->subadmin_id)
                ->first();

    if ($manager) {
        $currentPoints = $manager->points ?? 0;
        $amount = $request->amount;

        // নতুন পয়েন্ট হিসাব (প্লাস এ প্লাস হবে, মাইনাস এ বিয়োগ হবে)
        $newPoints = $currentPoints + $amount;

        // সুরক্ষা চেক: পয়েন্ট কি মাইনাসে চলে যেতে পারবে? 
        // যদি না চান যে ব্যালেন্স ০ এর নিচে নামুক, তবে এই চেকটি রাখুন:
        if ($newPoints < 0) {
            return back()->with('error', 'মামা, ম্যানেজারের ব্যালেন্স ০ এর নিচে নামানো যাবে না!');
        }

        // ডাটাবেজ আপডেট
        \Illuminate\Support\Facades\DB::table('managers')
            ->where('id', $request->subadmin_id)
            ->update([
                'points' => $newPoints,
                'updated_at' => now()
            ]);

        // মেসেজ ডাইনামিক করা (যোগ নাকি বিয়োগ)
        $msg = $amount > 0 ? "৳ $amount পয়েন্ট যোগ করা হয়েছে।" : "৳ " . abs($amount) . " পয়েন্ট কাটা হয়েছে।";

        return back()->with('success', $msg);
    }

    return back()->with('error', 'ম্যানেজার পাওয়া যায়নি!');
}
}
