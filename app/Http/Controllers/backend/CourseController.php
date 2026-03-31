<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yoeunes\Toastr\Facades\Toastr;

class CourseController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function course()
    {
        $courses = Course::with('Teacher')->get();
        return view('backend.course.course', compact('courses'));
    }

    public function courseCreate()
    {
        $teachers = Teacher::get();

        return view('backend.course.create', compact('teachers'));
    }

    public function courseStore(Request $request)
    {
        $courses = new Course();

        $courses->title = $request->title;
        $courses->slug = Str::slug($request->title);
        $courses->description = $request->description;
        $courses->summery = $request->summery;
        $courses->requrements = $request->requrements;
        $courses->duration = $request->duration;
        $courses->course_fee = $request->course_fee;
        $courses->teacher_id = $request->teacher_id;

          if(isset($request->thumbnail)){
            $imageName = rand().'.'.'Course'.'.'.$request->thumbnail->extension(); //12345.Course.webp
            $request->thumbnail->move('backend/images/courses/', $imageName);
            
            $courses->thumbnail = $imageName; 
        }
        $courses->save();
        toastr()->success('New Course Added Successfully');
        return redirect('/admin/course'); 
    }

   public function courseEdit($id)
   {
        $teachers = Teacher::get();
        $course = Course::find($id);
        return view('backend.course.edit-course', compact('teachers', 'course'));
   }

   public function courseUpdate(Request $request, $id)
   {
        $course = Course::find($id);

        $course->title = $request->title;
        $course->description = $request->description;
        $course->summery = $request->summery;
        $course->requrements = $request->requrements;
        $course->duration = $request->duration;
        $course->course_fee = $request->course_fee;
        $course->teacher_id = $request->teacher_id;

        if(isset($request->thumbnail)){

            if($course->thumbnail && file_exists('backend/images/courses/'.$course->thumbnail)){
                unlink('backend/images/courses/'.$course->thumbnail);
            }

            $imageName = rand().'-course'.'.'.$request->thumbnail->extension();
            $request->thumbnail->move('backend/images/courses/', $imageName);

            $course->thumbnail = $imageName;
        }

        $course->save();
        toastr()->success('Course Updated Successfully!');
        return redirect()->back();
   }

   public function courseDelete($id)
   {
        $course = Course::find($id);
        
        $course->delete();
        Toastr()->success('Course Deleted Successfully!');
        return redirect()->back();
   }
}