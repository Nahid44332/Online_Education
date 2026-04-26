<!doctype html>
<html lang="en">
<head>
   
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@7.4.47/css/materialdesignicons.min.css">
    
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

   @stack('script')
   <a href="https://wa.me/8801968400331" class="wa-floating-btn" target="_blank" title="Chat with us">
    <svg viewBox="0 0 32 32" class="wa-svg">
        <path d="M16 0c-8.837 0-16 7.163-16 16 0 2.825.737 5.48 2.025 7.788l-2.025 7.387 7.563-1.987c2.243 1.219 4.812 1.912 7.537 1.912 8.837 0 16-7.163 16-16s-7.163-16-16-16zm9.293 22.73c-.385 1.077-2.225 1.985-3.085 2.115-.777.115-1.785.163-2.885-.185-1.107-.345-2.585-.885-4.415-1.677-4.477-1.935-7.361-6.477-7.585-6.777-.225-.3-1.838-2.446-1.838-4.66s1.162-3.307 1.577-3.762c.415-.455.9-.57 1.2-.57s.6 0 .862.015c.277.015.646-.108 1.015.785.385.923 1.308 3.192 1.423 3.423s.192.485.015.83c-.169.354-.262.585-.523.892l-.785.915c-.254.3-.538.63-.23.1.308.538 1.37 2.254 2.946 3.654 2.023 1.8 3.723 2.362 4.254 2.63.53.27 1.077.208 1.477-.254.4-.462 1.723-2.015 2.185-2.707.462-.692.923-.577 1.546-.346s3.946 1.862 4.63 2.208c.685.346 1.146.515 1.315.8.169.285.169 1.63-.216 2.708z" fill="#fff"/>
    </svg>
</a>

<style>
    .wa-floating-btn {
        position: fixed;
        /* হলুদ বাটন থেকে অল্প একটু ওপরে রাখার জন্য ৮০ পিক্সেল দিলাম */
        bottom: 80px; 
        right: 25px;
        /* সাইজ কমিয়ে ৫০ পিক্সেল করে দিলাম যাতে বেশি বড় না লাগে */
        width: 50px;
        height: 50px;
        background-color: #25d366;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 9999;
        transition: all 0.3s ease;
    }

    .wa-svg {
        /* আইকন সাইজও একটু কমানো হলো */
        width: 28px;
        height: 28px;
    }

    .wa-floating-btn:hover {
        transform: scale(1.1);
        background-color: #20ba5a;
    }

    /* মোবাইলের জন্য আরও সলিড পজিশন */
    @media (max-width: 768px) {
        .wa-floating-btn {
            bottom: 75px; 
            width: 45px;
            height: 45px;
            right: 20px;
        }
        .wa-svg {
            width: 24px;
            height: 24px;
        }
    }
</style>

</body>
</html>
