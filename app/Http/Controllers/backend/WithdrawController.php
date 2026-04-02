<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function withdrawPage()
    {
        $student = Auth::guard('student')->user();
        $withdraws = WithdrawRequest::where('student_id',$student->id)->latest()->get();
        return view('backend.student-panel.withdraw.withdraw', compact('student', 'withdraws'));
    }

    public function withdrawRequest(Request $request)
    {
        $student = Auth::guard('student')->user();

        $request->validate([
            'points'=>'required|integer|min:100',
            'method'=>'required',
            'account_number'=>'required'
        ]);

        if($student->points < $request->points){
            return back()->with('error','Not enough points');
        }

        WithdrawRequest::create([
            'student_id'=>$student->id,
            'points'=>$request->points,
            'method'=>$request->method,
            'account_number'=>$request->account_number,
            'status'=>'pending'
        ]);

        return back()->with('success','Withdraw request submitted');
    }

}
