@extends('frontend.master')
@section('content')
    <!--====== SLIDER PART START ======-->

    <section id="slider-part" class="slider-active">
        @foreach ($banners as $banner)
            <div class="single-slider bg_cover pt-150"
                style="background-image: url({{ asset('backend/images/banner/' . $banner->image) }})" data-overlay="4">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-7 col-lg-9">
                            <div class="slider-cont">
                                <h1 data-animation="bounceInLeft" data-delay="1s">{{ $sitesettings->sitename }}</h1>
                                <p data-animation="fadeInUp" data-delay="1.3s">{{ $sitesettings->site_description }}</p>
                                <ul>
                                    <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn main-btn-2"
                                            href="{{url('/student/login')}}">Login</a></li>
                                    <li><a data-animation="fadeInUp" data-delay="1.9s" class="main-btn main-btn-2"
                                            href="{{ url('/admission') }}">Register</a></li>
                                </ul>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- single slider -->
        @endforeach
    </section>

    <!--====== SLIDER PART ENDS ======-->

    <!--====== CATEGORY PART START ======-->

    <section id="category-part">
        <div class="container">
            <div class="category pt-40 pb-80">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="category-text pt-40">
                            <h2>Best platform to learn everything</h2>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1 col-md-8 offset-md-2 col-sm-8 offset-sm-2 col-8 offset-2">
                        <div class="row category-slied mt-40">
                            <div class="col-lg-4">
                                <a href="#">
                                    <span class="singel-category text-center color-1">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-1.png') }}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Language</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="#">
                                    <span class="singel-category text-center color-2">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-2.png') }}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Business</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="#">
                                    <span class="singel-category text-center color-3">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-3.png') }}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Literature</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="#">
                                    <span class="singel-category text-center color-1">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-1.png') }}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Language</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="#">
                                    <span class="singel-category text-center color-2">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-2.png') }}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Business</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                            <div class="col-lg-4">
                                <a href="#">
                                    <span class="singel-category text-center color-3">
                                        <span class="icon">
                                            <img src="{{ asset('frontend/images/all-icon/ctg-3.png') }}" alt="Icon">
                                        </span>
                                        <span class="cont">
                                            <span>Literature</span>
                                        </span>
                                    </span> <!-- singel category -->
                                </a>
                            </div>
                        </div> <!-- category slied -->
                    </div>
                </div> <!-- row -->
            </div> <!-- category -->
        </div> <!-- container -->
    </section>

    <!--====== CATEGORY PART ENDS ======-->

    <!--====== ABOUT PART START ======-->

    <section id="about-part" class="pt-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-title mt-50">
                        <h5>About us</h5>
                        <h2>{{ $aboutus->title }}</h2>
                    </div> <!-- section title -->
                    <div class="about-cont">
                        <p>{{ $aboutus->description }}</p>
                        <a href="{{ url('/about-us') }}" class="main-btn mt-55">Learn More</a>
                    </div>
                </div> <!-- about cont -->
            </div> <!-- row -->
        </div> <!-- container -->
        <div class="about-bg">
            <img src="{{ asset('frontend/images/about/bg-1.png') }}" alt="About">
        </div>
    </section>

    <!--====== ABOUT PART ENDS ======-->

    <!--====== APPLY PART START ======-->

    <section id="apply-aprt" class="pb-120">
        <div class="container">
            <div class="apply">
                <div class="row no-gutters">
                    <div class="col-lg-6">
                        <div class="apply-cont apply-color-1">
                            <h3>Apply for Admission</h3>
                            <p>Gravida nibh vel velit auctor aliquetn sollicitudirem sem quibibendum auci elit cons equat
                                ipsutis sem nibh id elituis sed odio sit amet nibh vulputate cursus equat ipsutis.</p>
                            <a href="{{ url('/admission') }}" class="main-btn">Apply Now</a>
                        </div> <!-- apply cont -->
                    </div>
                    <div class="col-lg-6">
                        <div class="apply-cont apply-color-2">
                            <h3>Apply for intership</h3>
                            <p>Gravida nibh vel velit auctor aliquetn sollicitudirem sem quibibendum auci elit cons equat
                                ipsutis sem nibh id elituis sed odio sit amet nibh vulputate cursus equat ipsutis.</p>
                            <a href="{{ url('/teacer/application') }}" class="main-btn">Apply Now</a>
                        </div> <!-- apply cont -->
                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== APPLY PART ENDS ======-->

    <!--====== COURSE PART START ======-->

    <section id="course-part" class="pt-115 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-45">
                        <h5>Our course</h5>
                        <h2>Featured courses </h2>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row course-slied mt-30">
                @foreach ($courses as $course)
                    <div class="col-lg-4">
                        <div class="singel-course">
                            <div class="thum">
                                <div class="image">
                                    <a href="{{ url('course-details/' . $course->id) }}"><img
                                            src="{{ asset('backend/images/courses/' . $course->thumbnail) }}"
                                            alt="Course"></a>
                                </div>
                                <div class="price">
                                    <span>{{ $course->course_fee }}</span>
                                </div>
                            </div>
                            <div class="cont">
                                <ul>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                    <li><i class="fa fa-star"></i></li>
                                </ul>
                                <span>(20 Reviws)</span>
                                <a href="{{ url('course-details/' . $course->id) }}">
                                    <h4>{{ $course->title }}</h4>
                                </a>
                                <div class="course-teacher">
                                    <div class="thum">
                                        <a href="{{ url('teacher-info/' . $course->teacher->id) }}">
                                            <img src="{{ asset('backend/images/teachers/' . $course->teacher->profile_image) }}"
                                                alt="teacher">
                                        </a>
                                    </div>
                                    <div class="name">
                                        <a href="{{ url('teacher-info/' . $course->teacher->id) }}">
                                            <h6>{{ $course->teacher->name }}</h6>
                                        </a>
                                    </div>
                                    <div class="admin">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-user"></i><span>31</span></a></li>
                                            <li><a href="#"><i class="fa fa-heart"></i><span>10</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- singel course -->
                    </div>
                @endforeach
            </div> <!-- course slied -->
        </div> <!-- container -->
    </section>

    <!--====== COURSE PART ENDS ======-->

    <!--====== TEACHERS PART START ======-->

    <section id="teachers-part" class="pt-70 pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-title mt-50">
                        <h5>Featured Teachers</h5>
                        <h2>{{$teachereatured->feature_title}}</h2>
                    </div> <!-- section title -->
                    <div class="teachers-cont">
                        <p>{{$teachereatured->feature_description}}</p>
                        <a href="#" class="main-btn mt-55">Career with us</a>
                    </div> <!-- teachers cont -->
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="teachers mt-20">
                        <div class="row">
                            @foreach ($teachers as $teacher)
                                <div class="col-sm-6">
                                    <div class="singel-teachers mt-30 text-center">
                                        <div class="image">
                                            <a href="{{ url('teacher-info/' . $teacher->id) }}">
                                                <img src="{{ asset('backend/images/teachers/' . $teacher->profile_image) }}"
                                                    alt="Teachers" height="300" width="150">
                                            </a>
                                        </div>
                                        <div class="cont">
                                            <a href="{{ url('teacher-info/' . $teacher->id) }}">
                                                <h6>{{ $teacher->name }}</h6>
                                            </a>
                                            <span>{{ $teacher->designation }}</span>
                                        </div>
                                    </div> <!-- singel teachers -->
                                </div>
                            @endforeach
                        </div> <!-- row -->
                    </div> <!-- teachers -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </section>

    <!--====== TEACHERS PART ENDS ======-->

    <!--====== TEASTIMONIAL PART START ======-->

    <section id="testimonial" class="bg_cover pt-115 pb-115" data-overlay="8"
        style="background-image: url(images/bg-2.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-40">
                        <h5>Testimonial</h5>
                        <h2>What they say</h2>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->
            <div class="row testimonial-slied mt-40">
                @foreach ($testimonials as $testimonial)
                    <div class="col-lg-6">
                        <div class="singel-testimonial">
                            <div class="testimonial-thum">
                                <img src="{{ asset('backend/images/testimonial/' . $testimonial->image) }}"
                                    alt="Testimonial" height="100" width="100">
                                <div class="quote">
                                    <i class="fa fa-quote-right"></i>
                                </div>
                            </div>
                            <div class="testimonial-cont">
                                <p>{{ $testimonial->message }}</p>
                                <h6>{{ $testimonial->name }}</h6>
                                <span>{{ $testimonial->designation }}</span>
                            </div>
                        </div> <!-- singel testimonial -->
                    </div>
                @endforeach
            </div> <!-- testimonial slied -->
        </div> <!-- container -->
    </section>

    <!--====== TEASTIMONIAL PART ENDS ======-->

    <!--====== NEWS PART START ======-->

   <section id="news-part" class="pt-115 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-title pb-50">
                    <h5>Latest News</h5>
                    <h2>From the news</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @if($newspaper->count() > 0)
                @foreach ($newspaper as $news)
                    <div class="col-lg-6">
                        <div class="singel-news mt-30">
                            <div class="news-thum pb-25">
                                <img src="{{ asset('backend/images/news/'.$news->image) }}" alt="News">
                            </div>
                            <div class="news-cont">
                                <ul>
                                    <li><a href="#"><i class="fa fa-calendar"></i>{{ $news->created_at->format('d/m/y') }}</a></li>
                                    <li><a href="#"> <span>By</span> {{ $news->published_by }}</a></li>
                                </ul>
                                <a href="#"><h3>{{ $news->title }}</h3></a>
                                <p>{{ $news->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center mt-5">
                    <div class="alert alert-info">
                        No news available.
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
    <!--====== NEWS PART ENDS ======-->
@endsection
