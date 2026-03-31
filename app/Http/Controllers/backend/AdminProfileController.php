<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $admin = Auth::user();
        return view('backend.admin.profile', compact('admin'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $admin = Auth::user();

        $admin->name  = $request->name;
        $admin->email = $request->email;

        if (isset($request->image)) {

            if ($admin->image && file_exists('backend/images/admin/' . $admin->image)) {
                unlink('backend/images/admin/' . $admin->image);
            }

            $imageName = rand() . '-admin' . '.' . $request->image->extension();
            $request->image->move('backend/images/admin/', $imageName);

            $admin->image = $imageName;
        }

        $admin->save();

        toastr()->success('Profile Updated Successfully.');
        return redirect()->back();
    }

    public function changePassword()
    {
        return view('backend.admin.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $admin->password = Hash::make($request->new_password);
        $admin->save();

        toastr()->success('Password changed successfully.');
        return redirect()->back();
    }
}
