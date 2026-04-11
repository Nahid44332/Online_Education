<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Subadmin;
use App\Models\TeamLeader;
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
}
