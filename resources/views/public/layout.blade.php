<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ config('app.name') }} - {{ config('app.tagline') }}
        @endif
    </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('resources/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('resources/img/favicon.png') }}" rel="apple-touch-icon">
    
    <!-- Link Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('resources/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/admin/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('resources/vendor/fontawesome/css/all.min.css') }}" crossorigin="anonymous">

    <!-- Template Main CSS File -->
    <link href="{{ asset('resources/css/style.css') }}" rel="stylesheet">

    <style>
        .navbar .nav-link i {
            margin-right: 5px !important;
        }

        .btn-rounded {
            border-radius: 100px !important;
        }
        .input-error {
            color: red;
            font-size: 0.8em;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            margin: 0 !important;
        }

        .SumoSelect {
            width: 100% !important;
        }
        
    </style>

    @yield('custom-css')

</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center">

        <h1 class="logo me-auto"><a href="{{ url('/') }}" >SwiftCare</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="{{ url('/') }}" class="logo me-auto"><img src="{{ asset('resources/img/logo.png') }}"
                    alt="" class="img-fluid"></a> -->

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="{{url('/')}}">
                            Home</a>
                    </li>
                    <li><a class="nav-link scrollto" href="{{ url('book/doctor') }}">
                            Doctor</a>
                    </li>
                    <li><a class="nav-link   scrollto" href="{{ url('book/ambulance') }}">
                            Ambulance</a></li>
                    <li><a class="nav-link scrollto" href="{{ url('book/hospital') }}">
                            Hospital</a>
                    </li>
                    <li><a class="nav-link scrollto" href="{{ url('book/lab-test') }}">Lab
                            Test</a></li>
                    <!-- <button class="btn btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Get Started</button> -->
                    <li><a class="getstarted scrollto" href="{{url('contact')}}">Contact Us</a></li>

                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->



        <main id="main">

            @yield('body')
        </main><!-- End #main -->


    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-5 col-md-12 footer-info">
              <a href="index.html" class="logo d-flex align-items-center">
                <span>SwiftCare</span>
              </a>
              <p class="mt-4">Our healthcare services include ambulance, online hospital and doctor bookings, and home sample collection for laboratory testing. Our online platform makes it easy and efficient to access the care you need.</p>
              <div class="social-links d-flex mt-4">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>

            <div class="col-lg-2 col-6 footer-links">
              <h4>Quick Links</h4>
              <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Doctors</a></li>
                <li><a href="#">Ambulance</a></li>
                <li><a href="#">Hospital</a></li>
                <li><a href="#">Lab Test</a></li>
              </ul>
            </div>

            <div class="col-lg-2 col-6 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li><a href="#">Book Doctor</a></li>
                <li><a href="#">Home Healthcare</a></li>
                <li><a href="#">Lab Test</a></li>
                <li><a href="#">Book Hospital</a></li>
                <li><a href="#">Book Ambulance</a></li>
              </ul>
            </div>

            <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
              <h4>Contact Us</h4>
              <p>
                GS Road , Guwahati<br>
                Assam, India 781034<br>
                <br>
                <strong>Phone :</strong> +91 21345 67890<br>
                <strong>Email :</strong> info@swiftcare.com<br>
              </p>
            </div>

          </div>
        </div>

        <hr>
        <div class="container footer-bottom clearfix">
            <div class="copyright">
                &copy; Copyright <strong><span>SwiftCare</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="https://codepilot.in/">Codepilot Technologies Pvt. Ltd.</a>
            </div>
        </div>

     </footer><!-- End Footer -->
    <!-- End Footer -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content" style="border:1px solid #37517e">
      <div class="modal-header" style="border-bottom:none">
        <h5 class="modal-title" id="exampleModalLabel" style="border-bottom:none;color:#37517e;">Your Requirement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" >
      <div class="row">
                                    <div class="col-lg-12 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control shadow-none" id="floatingInput" placeholder="Enter Patient Name">
                                        <label for="name">Name</label>
                                    </div>

                                    </div>
                                    <div class="col-lg-12 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control shadow-none " id="phone" placeholder="Enter your Phone No">
                                        <label for="Phone">Phone No</label>
                                    </div>
                                    </div>
                                 
                                    <div class="col-lg-12 py-2">
                                            <div class="form-floating">
                                                <select class="form-select shadow-none " id="floatingSelect" aria-label="Floating label select example">
                                                    <option selected>Please select</option>
                                                    <option value="1">Book Doctor</option>
                                                    <option value="2">Book Ambulance</option>
                                                    <option value="3">Book Hospital</option>
                                                    <option value="4">Book Lab Test</option>
                                                </select>
                                                <label for="floatingSelect">Your Requirement</label>
                                                <div class="input-error"></div>
                                            </div>
                                    </div>
                                    <div class="col-lg-12 py-2">
                                    <div class="form-floating">
                                        <textarea class="form-control shadow-none" placeholder="Your Message" id="message" style="height: 70px"></textarea>
                                        <label for="address">Message</label>
                                    </div>
                                    </div>
                                </div>
      </div>
      <div class="modal-footer" style="border-top:none">
        <button type="button" class="btn btn-primary">Send Message</button>
      </div>
    </div>
  </div>
</div>


    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="{{ asset('resources/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('resources/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('resources/vendor/fontawesome/js/all.min.js') }}"></script>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <script src="{{ asset('resources/admin/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('resources/js/main.js') }}"></script>

    @yield('custom-js')

</body>

</html>
