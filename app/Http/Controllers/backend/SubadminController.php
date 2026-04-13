<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Subadmin;
use App\Models\TeamLeader;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
}
