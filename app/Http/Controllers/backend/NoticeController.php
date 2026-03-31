<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class NoticeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function Notice()
    {
        $notices = Notice::get();
        return view('backend.notice.notice', compact('notices'));
    }

    public function noticeCreate()
    {
        return view('backend.notice.create-notice');
    }

    public function noticeStore(Request $request)
    {
        $notice = new Notice();

        $notice->title = $request->title;
        $notice->description = $request->description;
        $notice->date = $request->date;
        $notice->status = $request->status;

        $notice->save();
        Toastr()->success('Notice Save Successfully');
        return redirect('/admin/notice');
    }

    public function toggleStatus($id)
    {
        $notice = Notice::find($id);
        $notice->status = !$notice->status; // Toggle status
        $notice->save();
        Toastr()->success('Notice status updated successfully.');
        return redirect()->back();
    }

    public function noticeDelete($id)
    {
        $notice = Notice::find($id);

        if (!$notice) {
            Toastr()->error('Notice not found.');
            return redirect()->back();
        }

        if ($notice->status == 1) {
            Toastr()->warning('Published notice cannot be deleted.');
            return redirect()->back();
        }

        $notice->delete();
        Toastr()->success('Successfully Delete Notice.');
        return redirect()->back();
    }

    public function noticeEdit($id)
    {  
        $notice = Notice::find($id);
        return view('backend.notice.edit-notice', compact('notice'));
    }

    public function noticeUpdate(Request $request,$id)
    {
        $notice = Notice::find($id);

        $notice->title = $request->title;
        $notice->description = $request->description;
        $notice->date = $request->date;
        $notice->status = $request->status;

        $notice->save();
        Toastr()->success('Notice Updated Successfully.');
        return redirect('/admin/notice');
    }
}
