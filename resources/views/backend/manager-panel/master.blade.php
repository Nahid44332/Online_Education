<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manager Panel</title>
   @include('backend.manager-panel.mg-include.style')
  </head>
  <body>
    <div class="container-scroller">

     @include('backend.manager-panel.mg-include.navber')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
      @include('backend.manager-panel.mg-include.sidebar')
        <!-- partial -->
        <div class="main-panel">
         @yield('content')
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          @include('backend.manager-panel.mg-include.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
   @include('backend.manager-panel.mg-include.script')
   @stack('script')
  </body>
</html>