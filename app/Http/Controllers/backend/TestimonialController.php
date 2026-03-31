<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class TestimonialController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function testimonial()
    {
        $testimonials = Testimonial::get();
        return view('backend.testimonial.testimonial', compact('testimonials'));
    }

    public function testimonialCreate()
    {
        return view('backend.testimonial.create');
    }

    public function testimonialStore(Request $request)
    {
        $testimonial = new Testimonial();

        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->message = $request->message;
        
        if(isset($request->image)){
            $imageName = rand().'.'.'testimonial'.'.'.$request->image->extension();
            $request->image->move('backend/images/testimonial/', $imageName);
            
            $testimonial->image = $imageName; 
        }

        $testimonial->save();
        Toastr()->success('Testimonials Create Successfully.');
        return redirect('/admin/testimonial');
    }

    public function testimonialDelete($id)
    {
        $testimonial = Testimonial::find($id);
        
        if($testimonial->image && file_exists('backend/images/testimonial/'.$testimonial->image)){
            unlink('backend/images/testimonial/'.$testimonial->image);
        }

        $testimonial->delete();
        Toastr()->success('Testimonial Delete Successfully.');
        return redirect()->back();
    }

    public function testimonialEdit($id)
    {
        $testimonial = Testimonial::find($id);
        return view('backend.testimonial.edit', compact('testimonial'));
    }

    public function testimonialUpdate(Request $request, $id)
    {
        $testimonial = Testimonial::find($id);
        
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->message = $request->message;

        if(isset($request->image)){

            if($testimonial->image && file_exists('backend/images/testimonial/'.$testimonial->image)){
                unlink('backend/images/testimonial/'.$testimonial->image);
            }

            $imageName = rand().'.testimonial'.'.'.$request->image->extension();
            $request->image->move('backend/images/testimonial/', $imageName);

            $testimonial->image = $imageName;
        }

        $testimonial->save();
        Toastr()->success('Testimonial Updated Successfully');
        return redirect('/admin/testimonial');
    }
}
