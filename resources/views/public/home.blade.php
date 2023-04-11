@extends('public.layout')

@section('custom-css')
<link rel="stylesheet" href="{{ asset('resources/css/home.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
@endsection
<!-- @section('hero')
@endsection -->

@section('body')
<section id="hero" class="col-10 mx-auto">
    <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

      <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

      <div class="carousel-inner" role="listbox">

        <!-- Slide 1 -->
        <div class="carousel-item active" style="background-image: url('{{ asset('resources/img/slide/slide-5.jpg')}}')" >

          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Welcome to <span>SwiftCare</span></h2>
              <p class="animate__animated animate__fadeInUp d-lg-block d-none">Our healthcare services include ambulance, online hospital and <br> doctor bookings, and home sample collection for laboratory testing. <br> Our online platform makes it easy and efficient to access the care you need.</p>
              <a href="#whyus" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item" style="background-image: url('{{ asset('resources/img/slide/slide-1.jpg')}}')">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Lorem Ipsum Dolor</h2>
              <p class="animate__animated animate__fadeInUp d-lg-block d-none">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et <br> est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. <br> Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
              <a href="#whyus" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <!-- <div class="carousel-item" style="background-image: url('{{ asset('resources/img/slide/slide-2.jpg')}}')">
          <div class="carousel-container">
            <div class="container">
              <h2 class="animate__animated animate__fadeInDown">Sequi ea ut et est quaerat</h2>
              <p class="animate__animated animate__fadeInUp">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam. Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus deleniti vel. Minus et tempore modi architecto.</p>
              <a href="#about" class="btn-get-started animate__animated animate__fadeInUp scrollto">Read More</a>
            </div>
          </div>
        </div> -->

      </div>

      <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
      </a>

      <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
      </a>

    </div>

</section>
    <!-- Our Service section start -->
    <section class="">
        <div class="container">
            <div class="section-title">
                <h2 data-aos="fade-right" data-aos-delay="200">Our Services</h2>
                <p data-aos="fade-left" data-aos-delay="200">
                    Our healthcare services include ambulance, online hospital and doctor bookings, and home sample
                    collection
                    for laboratory testing. Our online platform makes it easy and efficient to access the care you need.
                </p>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-3 p-3 wow backInUp" data-aos="fade-up" data-aos-delay="200">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <lord-icon src="https://cdn.lordicon.com/yalwfksd.json" trigger="loop"
                                colors="primary:#47b2e4,secondary:#121331" style="width:100px;height:100px">
                            </lord-icon>
                            <h5 class="service-title">Doctor</h5>
                            <div class="service-description">
                                Book appointments with doctors and avoid waiting in queues. Easy and fast online doctor
                                appointment booking.
                            </div>
                            <a href="{{ url('book/doctor') }}" class="btn btn-outline-primary d-block mt-1">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 p-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <lord-icon src="https://cdn.lordicon.com/mypzgycw.json" trigger="loop"
                                colors="primary:#121331,secondary:#47b2e4" style="width:100px;height:100px">
                            </lord-icon>
                            <h5 class="service-title">Home Healthcare</h5>
                            <div class="service-description">
                                Experience compassionate and personalized care from our skilled healthcare providers in the
                                comfort of your own home.
                            </div>
                            <a href="{{ url('book/home-healthcare') }}" class="btn btn-outline-primary d-block mt-1">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 p-3" data-aos="fade-up" data-aos-delay="600">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <lord-icon src="https://cdn.lordicon.com/oswatybr.json" trigger="loop" delay="2000"
                                colors="primary:#47b2e4,secondary:#121331" style="width:100px;height:100px">
                            </lord-icon>
                            <h5 class="service-title">Lab Test</h5>
                            <div class="service-description">
                                Get accurate and convenient laboratory testing from the comfort of your home with our
                                doorstep lab test services.
                            </div>
                            <a href="{{ url('book/lab-test') }}" class="btn btn-outline-primary d-block mt-1">Book Now</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3 p-3" data-aos="fade-up" data-aos-delay="800">
                    <div class="card service-card">
                        <div class="card-body text-center">
                            <lord-icon src="https://cdn.lordicon.com/hdiorcun.json" trigger="loop" delay="2000"
                                colors="primary:#47b2e4,secondary:#121331" style="width:100px;height:100px">
                            </lord-icon>
                            <h5 class="service-title">Hospital</h5>
                            <div class="service-description">
                                Book appointments at top hospitals from the comfort of your home. Easy, fast, and convenient
                                online hospital booking.
                            </div>
                            <a href="{{ url('book/hospital') }}" class="btn btn-outline-primary d-block mt-1">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

      <!-- why choose us section start -->
    <section id="whyus">
        <div class="container">
            <div class="section-title">
                <h2 data-aos="fade-right" data-aos-delay="400">Why Choose Us</h2>
                <p data-aos="fade-left" data-aos-delay="400">
                    Choose us for convenient and quality healthcare services
                </p>
            </div>

            <div class="row">
                <div class="col-md-6 p-2" data-aos="fade-right" data-aos-delay="600">
                    <div class="card wcu-card">
                        <div class="wcu-img-box"
                            style="height: 200px; background: url('{{ asset('resources/img/wcu/service.jpg') }}');
                                background-position: center; background-size: cover;">
                        </div>
                        <div class="wcu-content">
                            <h5 class="wcu-title">Comprehensive Services</h5>
                            <div class="wcu-para text-secondary">
                                We offer a range of healthcare services including ambulance, online hospital and doctor
                                bookings, and home sample collection for laboratory testing, all in one platform.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-2" data-aos="fade-left" data-aos-delay="600">
                    <div class="card wcu-card">
                        <div class="wcu-img-box"
                            style="height: 200px; background: url('{{ asset('resources/img/wcu/convenient.jpg') }}');
                                background-position: center; background-size: cover;">
                        </div>
                        <div class="wcu-content">
                            <h5 class="wcu-title">Convenience</h5>
                            <div class="wcu-para text-secondary">
                                Our online platform makes it easy for you to access healthcare services from the comfort of
                                your own
                                home, saving you time and effort.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-2" data-aos="fade-right" data-aos-delay="200">
                    <div class="card wcu-card">
                        <div class="wcu-img-box"
                            style="height: 200px; background: url('{{ asset('resources/img/wcu/care.jpg') }}');
                                background-position: center; background-size: cover;">
                        </div>
                        <div class="wcu-content">
                            <h5 class="wcu-title">Quality care</h5>
                            <div class="wcu-para text-secondary">
                                We prioritize the quality of care we provide to our patients, with trained medical
                                professionals and
                                top-rated hospitals and doctors in our network.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-2" data-aos="fade-left" data-aos-delay="200">
                    <div class="card wcu-card">
                        <div class="wcu-img-box"
                            style="height: 200px; background: url('{{ asset('resources/img/wcu/timeliness.jpg') }}');
                                background-position: center; background-size: cover;">
                        </div>
                        <div class="wcu-content">
                            <h5 class="wcu-title">Timeliness</h5>
                            <div class="wcu-para text-secondary">
                                We understand that time is of the essence in healthcare. That is why we strive to provide
                                quick and
                                efficient
                                services to our patients.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

     <!--  Call To Action Section section start-->
    <section id="call-to-action" class="call-to-action">
        <div class="container" data-aos="zoom-out">
        <div class="row justify-content-center">
          <div class="col-lg-8 text-center">
          <lord-icon src="https://cdn.lordicon.com/ssvybplt.json" trigger="loop" colors="primary:#fff" style="width:50px;height:50px" data-aos="fade-in" data-aos-delay="200" class="aos-init aos-animate">
                            </lord-icon>
            <h3 class="mt-4">24/7 Call Assistance for Your Peace of Mind</h3>
            <p>
            We understand that emergencies can happen at any time, which is why we offer 24/7 call assistance for all our services. Our trained professionals are ready to assist you anytime, anywhere, ensuring your peace of mind and timely access to healthcare services.
            </p>
            <a class="btn btn-outline-light" href="#"><i class="fa fa-phone"></i> +91 9876543210</a>
          </div>
        </div>

      </div>
    </section>
    <!-- End Call To Action Section -->
    <!-- Testimonial section start -->
    <section class="client-testimonial">
        <div class="container">
                <div class="section-title">
                            <h2 data-aos="fade-left" >Client Testimonials</h2>
                </div>
                <div class="row">
                    <div class="col-md-10 mx-auto">
                        <div class="testimonial-bg">
                            <div id="testimonial-slider" class="owl-carousel">
                                <div class="testimonial">
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at augue sed elit eleifend tempus. Etiam malesuada vulputate justo quis bibendum. Nam maximus ultricies rhoncus. Ut non felis vel enim dapibus.
                                    </p>
                                    <div class="pic">
                                        <img src="{{asset('resources/img/testimonials/client-1.png')}}" alt="client-1">
                                    </div>
                                    <h3 class="title">Jemmy Ferara,</h3>
                                    <span class="post">USA</span>
                                </div>
            
                                <div class="testimonial">
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at augue sed elit eleifend tempus. Etiam malesuada vulputate justo quis bibendum. Nam maximus ultricies rhoncus. Ut non felis vel enim dapibus.
                                    </p>
                                    <div class="pic">
                                        <img src="{{asset('resources/img/testimonials/client-2.png')}}" alt="client-2">
                                    </div>
                                    <h3 class="title">Kristiana Adam,</h3>
                                    <span class="post">London</span>
                                </div>

                                <div class="testimonial">
                                    <p class="description">
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at augue sed elit eleifend tempus. Etiam malesuada vulputate justo quis bibendum. Nam maximus ultricies rhoncus. Ut non felis vel enim dapibus.
                                    </p>
                                    <div class="pic">
                                        <img src="{{asset('resources/img/testimonials/client-3.png')}}" alt="client-3">
                                    </div>
                                    <h3 class="title">Hyms Deram,</h3>
                                    <span class="post">East Africa</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
    <!-- Testimonial section ends -->

@section('custom-js')
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
 
  <script>
    $(document).ready(function(){
    $("#testimonial-slider").owlCarousel({
        items:1,
        itemsDesktop:[1000,1],
        itemsDesktopSmall:[979,1],
        itemsTablet:[768,1],
        pagination:false,
        navigation:true,
        navigationText:["",""],
        autoPlay:true
    });
});
  </script>

@endsection
