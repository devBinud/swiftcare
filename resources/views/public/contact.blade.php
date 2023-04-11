@extends('public.layout')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('resources/css/contact.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/css/booking.css') }}">
@endsection

@section('body')
    <div class="banner">
        <div class="content__wrapper">
               <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

      </div>

      <div class="container">

        <div class="row mt-5">

          <div class="col-lg-6">

            <div class="row">
              <div class="col-md-12">
                <div class="info-box">
                  <i class="bx bx-map"></i>
                  <h3>Our Address</h3>
                  <p>Guwahati, Assam</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box mt-4">
                  <i class="bx bx-envelope"></i>
                  <h3>Email Us</h3>
                  <p>info@example.com<br>contact@example.com</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box mt-4">
                  <i class="bx bx-phone-call"></i>
                  <h3>Call Us</h3>
                  <p>+91 12345 67890<br>+91 90876 54567</p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                    <div class="form-floating mb-3">
                            <input type="text" class="form-control shadow-none" id="floatingInput" placeholder="Enter Patient Name">
                            <label for="name">Name</label>
                    </div>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                <div class="form-floating mb-3">
                                        <input type="number" class="form-control shadow-none " id="phone" placeholder="Enter your Phone No">
                                        <label for="Phone">Phone No</label>
                                    </div>
                </div>
              </div>
              <div class="form-group mt-3">
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
              <div class="form-group mt-3">
              <div class="form-floating">
                                        <textarea class="form-control shadow-none" placeholder="Your Message" id="message" style="height: 130px"></textarea>
                                        <label for="address">Message</label>
                                    </div>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->
        </div>
    </div>
@endsection

@section('custom-js')
@endsection
