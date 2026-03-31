<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Featured;
use App\Models\Teacher;
use App\Models\TeacherApplication;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class teachersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addTeacher()
    {
        return view('backend.teacher.add-teacher');
    }

    public function teacherStore(Request $request)
    {
        // --- Student Data Save ---
        $teacher = new Teacher();

        $teacher->name = $request->name;
        $teacher->designation = $request->designation;
        $teacher->phone = $request->phone;
        $teacher->about = $request->about;
        $teacher->achievements = $request->achievements;
        $teacher->objective = $request->objective;
        $teacher->short_description = $request->short_description;
        $teacher->facebook_link = $request->facebook_link;
        $teacher->twitter_link = $request->twitter_link;
        $teacher->google_link = $request->google_link;
        $teacher->linkedin_link = $request->linkedin_link;

        // --- Image Upload ---
        if (isset($request->profile_image)) {
            $imageName = rand() . '-teacher' . '.' . $request->profile_image->extension(); //12345-teacher-.webp
            $request->profile_image->move('backend/images/teachers/', $imageName);

            $teacher->profile_image = $imageName;
        }

        $teacher->save();
        toastr()->success('You have been Ragistered Successfully!');
        return redirect()->back();
    }

    public function teacherList()
    {
        $teachers = Teacher::get();
        return view('backend.teacher.teacher-list', compact('teachers'));
    }

    public function teacherView($id)
    {
        $teacher = Teacher::find($id);
        return view('backend.teacher.view-teacher', compact('teacher'));
    }

    public function teacherDelete($id)
    {
        $teacher = Teacher::find($id);

        if ($teacher->profile_image && file_exists('backend/images/teachers/' . $teacher->profile_image)) {
            unlink('backend/images/teachers/' . $teacher->profile_image);
        }

        $teacher->delete();
        Toastr()->success('Teacher Deleted Successfully!');
        return redirect()->back();
    }

    public function teacherEdit($id)
    {
        $teachers = Teacher::find($id);
        return view('backend.teacher.edit-teacher', compact('teachers'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        $teacher->name = $request->name;
        $teacher->designation = $request->designation;
        $teacher->phone = $request->phone;
        $teacher->about = $request->about;
        $teacher->achievements = $request->achievements;
        $teacher->objective = $request->objective;
        $teacher->short_description = $request->short_description;
        $teacher->facebook_link = $request->facebook_link;
        $teacher->twitter_link = $request->twitter_link;
        $teacher->google_link = $request->google_link;
        $teacher->linkedin_link = $request->linkedin_link;

        if (isset($request->profile_image)) {

            if ($teacher->profile_image && file_exists('backend/images/teachers/' . $teacher->profile_image)) {
                unlink('backend/images/teachers/' . $teacher->profile_image);
            }

            $imageName = rand() . '-teacher' . '.' . $request->profile_image->extension(); //12345-teacher-.webp
            $request->profile_image->move('backend/images/teachers/', $imageName);

            $teacher->profile_image = $imageName;
        }

        $teacher->save();
        Toastr()->success('Teachers info Updated Successfully!');
        return redirect('/admin/teacher/list');
    }

    public function assignCourse($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id); // টিচার খুঁজে নাও
        $courses = Course::all(); // সব কোর্স দেখাও
        return view('backend.teacher.assign-course', compact('teacher', 'courses'));
    }

    public function storeAssignCourse(Request $request)
    {
        $course_id = $request->course_id;
        $teacher_id = $request->teacher_id;

        $course = Course::findOrFail($course_id);

        $newCourse = new Course();

        $newCourse->title = $course->title;
        $newCourse->slug = Str::slug($course->title . '-' . time());
        $newCourse->thumbnail = $course->thumbnail;
        $newCourse->teacher_id = $teacher_id;

        // Check and assign NOT NULL columns safely
        if (Schema::hasColumn('courses', 'course_fee')) {
            $newCourse->course_fee = $course->course_fee ?? 0;
        }
        if (Schema::hasColumn('courses', 'duration')) {
            $newCourse->duration = $course->duration ?? '1 month';
        }
        if (Schema::hasColumn('courses', 'summery')) {
            $newCourse->summery = $course->summery ?? 'No summary provided';
        }
        if (Schema::hasColumn('courses', 'description')) {
            $newCourse->description = $course->description ?? 'No description';
        }
        if (Schema::hasColumn('courses', 'requrements')) {
            $newCourse->requrements = $course->requrements ?? 'No requirements';
        }

        $newCourse->save();

        Toastr()->success('Course assigned to teacher successfully!');
        return redirect('/admin/course');
    }

    public function teacherCendidate()
    {
        $applications = TeacherApplication::latest()->get();
        return view('backend.teacher.cendidate', compact('applications'));
    }

    public function show($id)
    {
        $application = TeacherApplication::findOrFail($id);
        return view('backend.teacher.show-cendidate', compact('application'));
    }

    // Approve Application
    public function approve($id)
    {
        $application = TeacherApplication::findOrFail($id);
        $application->status = 'approved';
        $application->save();

        Toastr()->success('Application Approved');
        return redirect()->back();
    }

    // Reject Application
    public function reject($id)
    {
        $application = TeacherApplication::findOrFail($id);
        $application->status = 'rejected';
        $application->save();

        Toastr()->error('Application Rejected');
        return redirect()->back();
    }

    public function deleteApplicate($id)
    {
        $application = TeacherApplication::find($id);

        if ($application) {
            
            if ($application->image && file_exists(public_path('backend/images/applicatecendidate/'.$application->image))) {
                unlink(public_path('backend/images/applicatecendidate/'.$application->image));
            }

            if ($application->cv && file_exists(public_path('backend/file/cv/'.$application->cv))) {
                unlink(public_path('backend/file/cv/'.$application->cv));
            }

            $application->delete();

            Toastr()->success('Application Deleted Successfully.');
        }
        else {
            Toastr()->error('Application Not Found');
        }

        return redirect()->back();
    }

    public function teacherFeatured()
    {
        $teachereatured = Featured::first();
        return view('backend.teacher.teacher-featured', compact('teachereatured'));
    }

    public function teacherFeaturedUpdate(Request $request)
    {
        $teachereatured = Featured::first();

        $teachereatured->feature_title = $request->feature_title;
        $teachereatured->feature_description = $request->feature_description;

        $teachereatured->save();
        toastr()->success('Teacher Featured Updated Successfully.');
        return redirect()->back();
    }
}
