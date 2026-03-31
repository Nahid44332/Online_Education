<!doctype html>
<html lang="en">
<head>
   
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!--====== Title ======-->
    <title>Edubin</title>
   @include('frontend.include.style')
</head>
<body>
    <!--====== HEADER PART START ======-->
  @include('frontend.include.header')
    
    <!--====== HEADER PART ENDS ======-->
   
   @yield('content')
   
    <!--====== FOOTER PART START ======-->
    
    @include('frontend.include.footer')
    
    <!--====== FOOTER PART ENDS ======-->
   
    <!--====== BACK TO TP PART START ======-->
    
    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
    
    <!--====== BACK TO TP PART ENDS ======-->
   @include('frontend.include.script')

</body>
</html>
