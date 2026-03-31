<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Lock;
use App\Models\Student;
use Illuminate\Http\Request;

class lockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show all students with lock status
    public function studentLock()
    {
        // Load students with their lock relation
        $students = Student::with('lock')->get();

        return view('backend.lock.lock', compact('students'));
    }

    // Lock a student
    public function lock($studentId)
    {
        Lock::updateOrCreate(
            ['student_id' => $studentId],
            [
                'is_locked' => 1,
                'locked_at' => now(),
            ]
        );

        return back()->with('success', 'Student locked successfully');
    }

    // Unlock a student
    public function unlock($studentId)
    {
        Lock::updateOrCreate(
            ['student_id' => $studentId],
            [
                'is_locked' => 0,
                'locked_at' => null,
            ]
        );

        return back()->with('success', 'Student unlocked successfully');
    }
}
