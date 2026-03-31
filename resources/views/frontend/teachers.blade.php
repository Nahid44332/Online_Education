@extends('frontend.master')
@section('content')
 <!--====== PAGE BANNER PART START ======-->
    
    <section id="page-banner" class="pt-105 pb-110 bg_cover" data-overlay="8" style="background-image: url({{asset('frontend/images/page-banner-3.jpg')}})">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-banner-cont">
                        <h2>Teachers</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Teachers</li>
                            </ol>
                        </nav>
                    </div>  <!-- page banner cont -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>
    
    <!--====== PAGE BANNER PART ENDS ======-->
   
    <!--====== TEACHERS PART START ======-->
    
  <section id="teachers-page" class="pt-90 pb-120 gray-bg">
    <div class="container">
       <div class="row">
          @foreach ($teachers as $teacher)
               <div class="col-lg-3 col-sm-6">
                   <div class="singel-teachers mt-30 text-center">
                        <div class="image">
                            <img src="{{asset('backend/images/teachers/'.$teacher->profile_image)}}" alt="Teachers" height="250" width="150">
                        </div>
                        <div class="cont">
                            <a href="{{url('teacher-info/'.$teacher->id)}}">
                                <h6>{{ $teacher->name }}</h6>
                            </a>
                            <span>{{ $teacher->designation }}</span>
                        </div>
                    </div> <!-- singel teachers -->
               </div>
          @endforeach
       </div>
    </div> <!-- container -->
</section>
@endsection