<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function news()
    {
        $newspaper = News::get();
        return view('backend.news.news-list', compact('newspaper'));
    }

    public function newsCreate()
    {
        return view('backend.news.create-news');
    }

    public function newsStore(Request $request)
    {
        $news = new News();

        $news->title = $request->title;
        $news->slug = Str::slug($request->title, '-');
        $news->description = $request->description;
        $news->published_by = $request->published_by;
        $news->status = $request->status;

        if (isset($request->image)) {
            $imageName = rand() . '.' . 'news' . '.' . $request->image->extension();
            $request->image->move('backend/images/news/', $imageName);

            $news->image = $imageName;
        }

        $news->save();
        toastr()->success('News Created Successfully');
        return redirect('/admin/news');
    }

    public function changeStatus($id)
    {
        $news = News::findOrFail($id);

        if ($news->status == 1) {
            $news->status = 0; // Inactive
        } else {
            $news->status = 1; // Active
        }

        $news->save();

        toastr()->success('Status updated successfully');
        return redirect()->back();
    }

    public function newsEdit($id)
    {
        $news = News::find($id);
        return view('backend.news.edit-new', compact('news'));
    }

    public function newsUpdate(Request $request , $id)
    {
        $news = News::find($id);
        
        $news->title = $request->title;
        $news->description = $request->description;
        $news->published_by = $request->published_by;
        $news->status = $request->status;
        if(isset($request->image)){

            if($news->image && file_exists('backend/images/news/'.$news->image)){
                unlink('backend/images/news/'.$news->image);
            }

            $imageName = rand().'-teacher'.'.'.$request->image->extension();
            $request->image->move('backend/images/news/', $imageName);

            $news->image = $imageName;
        }

        $news->save();
        toastr()->success('News Update Successfully.');
        return redirect('/admin/news');
    }

    public function newsDelete($id)
    {
        $newsDelete = News::find($id);
        
    if ($newsDelete->status == 1) {
        toastr()->error('Published news cannot be deleted. Please unpublish first.');
        return redirect()->back();
    }

    if ($newsDelete->image && file_exists(public_path('backend/images/news/'.$newsDelete->image))) {
        unlink(public_path('backend/images/news/'.$newsDelete->image));
    }

        $newsDelete->delete();
        toastr()->success('News Deleted Successfully.');
        return redirect()->back();
    }
}
