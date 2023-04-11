@extends('public.layout') @section('custom-css')
<link rel="stylesheet" href="{{ asset('resources/css/booking.css') }}" />
<link rel="stylesheet" href="{{ asset('resources/css/book-doctors.css') }}" />
<link href="{{ asset('resources/vendor/sumo-select/sumoselect.min.css') }}" rel="stylesheet"/>
  <!-- Link Datepicker CSs -->
<!-- <link rel="stylesheet" href="{{asset('resources/datepicker/css/zebra_datepicker.min.css')}}"/> -->
<link href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet"/>

<!-- ✅ load jQuery ✅ -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="crossorigin="anonymous"></script>

<!-- ✅ load jquery UI ✅ -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"
integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
<style>
  .text-main {
    color: #37517e;
  }

  ::placeholder {
    font-size: 15px;
  }

  .form-control[type="file"] {
    font-size: 15px;
    font-weight: 300 !important;
  }

  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    appearance: none !important;
    margin: 0 !important;
  }

  .doctor-img {
    width: 100%;
    height: 150px;
  }

  .card-doctor {
    border-radius: 5px;
    transition: 0.2s;
    overflow: hidden;
  }

  .card-doctor:hover {
    box-shadow: 0px 0px 5px lightgrey;
  }

  rgb(233, 233, 233) .card-doctor .doctor-content {
    background: rgba(228, 248, 255, 0.3);
  }

  .doctor-name {
    color: brown;
    /* font-weight: bold; */
  }
</style>
@endsection @section('body')
<form action="" method="POST" id="formBook">
  @csrf
  <input type="hidden" name="latitude" />
  <input type="hidden" name="longitude" />
  <div class="banner">
    <div class="content__wrapper">
      <div class="container" id="bookingMessage">
        <div class="upper__layer__text py-3">
          <h3 class="layer__para__second fw-medium">
            Book Your Next Doctor's Appointment Online with Us
          </h3>
          <p class="layer__para__first">
            We offer a user-friendly online platform that allows patients to
            easily schedule appointments with healthcare providers at their
            convenience.
          </p>
        </div>
        <div class="form__wrapper bg-white p-lg-4">
          <!-- ======= doctors Section ======= -->
          <div id="doctors" class="doctors">
            <div class="container" data-aos="fade-up">
              <h5 class="mb-4 pt-lg-0 pt-4" style="color:#37517e">Choose Speciality</h5>
              <ul class="nav nav-tabs row g-2 d-flex">
                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-1">
                    <h4>Orthopedics</h4>
                  </a>
                </li>
                <!-- End tab nav item -->

                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link"  data-bs-toggle="tab" data-bs-target="#tab-2">
                    <h4>Pediatrics</h4> </a
                  ><!-- End tab nav item -->
                </li>

                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-3">
                    <h4>Dental</h4>
                  </a>
                </li>
                <!-- End tab nav item -->

                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link"  data-bs-toggle="tab" data-bs-target="#tab-4">
                    <h4>Dermatology</h4>
                  </a>
                </li>
                <!-- End tab nav item -->

                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link"  data-bs-toggle="tab" data-bs-target="#tab-5">
                    <h4>Gynecology</h4>
                  </a>
                </li>
                <!-- End tab nav item -->
                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link" data-bs-toggle="tab"  data-bs-target="#tab-6">
                    <h4>Gastroenterology</h4>
                  </a>
                </li>
                <!-- End tab nav item -->
                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-7">
                    <h4>General Surgery</h4>
                  </a>
                </li>
                <!-- End tab nav item -->
                <li class="nav-item col-6 col-lg-3">
                  <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-8">
                    <h4>Pregnancy</h4>
                  </a>
                </li>
                <!-- End tab nav item -->
              </ul>

              <div class="tab-content">
                <div class="tab-pane active show" id="tab-1">
                  <div class="row">
                    <div class="col-lg-6 order-1 order-lg-1 mt-3 mt-lg-0 d-flex flex-column py-2">
                      <h5 class="mb-4" style="color:#37517e">Doctors</h5>
                      <!-- Doctor list radio section start -->
                      <div class="grid">
                        <label class="card">
                          <input name="plan" class="radio" type="radio" />
                          <span class="plan-details" aria-hidden="true">
                            <img src="{{asset('resources/img/doctor.jpg')}}"  class="card-img-top" alt="..."
                              style="max-height: 200px;"/>
                            <h5 class="card-title mt-3">Dr Runumi Sarma</h5>
                            <h6 class="card-subtitle text-body-secondary">
                              General Physician
                            </h6>
                            <p class="card-text my-1">
                              7 + Years of Experience
                            </p>
                          </span>
                        </label>
                        <label class="card">
                          <input name="plan" class="radio" type="radio" />
                          <span class="plan-details" aria-hidden="true">
                            <img src="{{asset('resources/img/doctor.jpg')}}"  class="card-img-top"  alt="..."
                              style="max-height: 200px;"  />
                            <h5 class="card-title mt-3">Dr Abhilash Singh</h5>
                            <h6 class="card-subtitle text-body-secondary">
                              General Physician
                            </h6>
                            <p class="card-text my-1">
                              5 + Years of Experience
                            </p>
                          </span>
                        </label>
                        <label class="card">
                          <input name="plan" class="radio" type="radio" />
                          <span class="plan-details" aria-hidden="true">
                            <img
                              src="{{asset('resources/img/doctor.jpg')}}"
                              class="card-img-top"
                              alt="..."
                              style="max-height: 200px;" />
                            <h5 class="card-title mt-3">Dr Arnab Gohain</h5>
                            <h6 class="card-subtitle text-body-secondary">
                              General Physician
                            </h6>
                            <p class="card-text my-1">
                              8 + Years of Experience
                            </p>
                          </span>
                        </label>
                      </div>
                      <!-- Doctor list radio section ends -->
                    </div>
                    <div class="col-lg-6 order-1 order-lg-2 mt-3 mt-lg-0 d-flex flex-column py-2" style="overflow:scroll">
                      <h5 class="mb-4" style="color:#37517e">Clinic</h5>
                      <!-- Clinic list radio section start -->
                      <div class="grid">
                        <label class="card" style="width: 18rem;">
                          <input name="plan" class="radio" type="radio" />
                          <span class="plan-details" aria-hidden="true">
                            <h5 class="card-title mt-3">Precision Clinic</h5>
                            <h6 class="card-subtitle text-body-secondary mb-2">
                              Narakasur | Guwahati , Assam
                            </h6>
                            <!-- ======= Time slot section start ======= -->
                            <section id="features" class="features">
                              <div class="container" data-aos="fade-up">

                                <ul class="nav nav-tabs row  g-2 d-flex">

                                  <li class="nav-item col-12">
                                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-10">
                                      <h4>02:00 PM - 04:00 PM</h4>
                                    </a>
                                  </li><!-- End tab nav item -->

                                  <li class="nav-item col-12">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-11">
                                      <h4>02:00 PM - 04:00 PM</h4>
                                    </a><!-- End tab nav item -->

                                  <li class="nav-item col-12">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-12">
                                      <h4>02:00 PM - 04:00 PM</h4>
                                    </a>
                                  </li><!-- End tab nav item -->
                                </ul>

                                <div class="tab-content">

                                  <div class="tab-pane active show" id="tab-10">
                                    <label for="date" style="color:#37517e;">Select date <span class="text-danger"> *</span></label>
                                    <p><input type="text"  id="datepicker"/></p>
                                  </div><!-- End tab content item -->

                                  <div class="tab-pane" id="tab-11">
                                    <div class="row">
                                    <label for="date" style="color:#37517e;">Select date <span class="text-danger"> *</span></label>
                                    <p><input type="text" id="datepicker"/></p>
                                    </div>
                                  </div><!-- End tab content item -->

                                  <div class="tab-pane" id="tab-12">
                                    <div class="row">
                                    <label for="date" style="color:#37517e;">Select date <span class="text-danger"> *</span></label>
                                    <p><input type="text" id="datepicker"/></p>

                                    </div>
                                  </div><!-- End tab content item -->

                                </div>
                                <button class="btn btn-outline-primary w-100 mt-4" onclick="onSelect()">Select Clinic</button>

                              </div>

                              <div class="patient__form mt-4" id="patient__form" style="display:none">
                                  <form>
                                    <div class="form-group">
                                      <input type="text" class="form-control" id="name" aria-describedby="" placeholder="Enter your Name"  autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                      <input type="text" class="form-control" id="phone" placeholder="Phone No" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                      <input type="text" class="form-control" id="age" placeholder="Age" autocomplete="off">
                                    </div>
                                    <div class="form-group">
                                      <textarea class="form-control mt-2" id="address" rows="3" placeholder="Your Address"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3 w-100">Book Now</button>
                                  </form>
                              </div>
                            </section>
                            <!-- Time slot section ends-->
                          </span>
                        </label>
                        <label class="card" style="width: 18rem;">
                          <input name="plan" class="radio" type="radio" />
                          <span class="plan-details" aria-hidden="true">
                            <h5 class="card-title mt-3">Apollo Clinic</h5>
                            <h6 class="card-subtitle text-body-secondary mb-2">
                              GS Road | Guwahati , Assam
                            </h6>
                              <!-- ======= Time slot section start ======= -->
                              <section id="features" class="features">
                              <div class="container" data-aos="fade-up">

                                <ul class="nav nav-tabs row  g-2 d-flex">

                                  <li class="nav-item col-12">
                                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#tab-21">
                                      <h4>02:00 PM - 04:00 PM</h4>
                                    </a>
                                  </li><!-- End tab nav item -->

                                  <li class="nav-item col-12">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-22">
                                      <h4>02:00 PM - 04:00 PM</h4>
                                    </a><!-- End tab nav item -->

                                  <li class="nav-item col-12">
                                    <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-23">
                                      <h4>02:00 PM - 04:00 PM</h4>
                                    </a>
                                  </li><!-- End tab nav item -->
                                </ul>

                                <div class="tab-content">
                                  <div class="tab-pane active show" id="tab-21">
                                  <label for="date" style="color:#37517e;">Select date <span class="text-danger"> *</span></label>
                                    <p><input type="text" id="datepicker"/></p>
                                  </div><!-- End tab content item -->

                                  <div class="tab-pane" id="tab-22">
                                    <div class="row">
                                    <label for="date" style="color:#37517e;">Select date <span class="text-danger"> *</span></label>
                                    <p><input type="text" id="datepicker"/></p>
                                    </div>
                                  </div><!-- End tab content item -->

                                  <div class="tab-pane" id="tab-23">
                                    <div class="row">
                                    <label for="date" style="color:#37517e;">Select date <span class="text-danger"> *</span></label>
                                    <p><input type="text" id="datepicker"/></p>

                                    </div>
                                  </div><!-- End tab content item -->

                                </div>
                                <a href="#" class="btn btn-outline-primary w-100 mt-4">Select Clinic</a>

                              </div>
                            </section>
                            <!-- Time slot section ends-->
                          </span>
                        </label>
                      </div>
                      <!-- Clinic list radio section ends -->
                    </div>
                  </div>
                </div>
                <!-- End tab content item -->

                <div class="tab-pane" id="tab-2">
                  <div class="row">
                  <h5>Pediatrics</h5>
                  </div>
                </div>
                <!-- End tab content item -->

                <div class="tab-pane" id="tab-3">
                  <div class="row">
                      <h5>Dental</h5>
                  </div>
                </div>
                <!-- End tab content item -->

                <div class="tab-pane" id="tab-4">
                  <div class="row">
                   <h5>Dermatology</h5>
                  </div>
                </div>
                <!-- End tab content item -->

                <div class="tab-pane" id="tab-5">
                  <div class="row">
                   <h5>Gynecology</h5>
                  </div>
                </div>
                <!-- End tab content item -->
                <div class="tab-pane" id="tab-6">
                  <div class="row">
                    <h5>Gastroenterology</h5>
                  </div>
                </div>
                <!-- End tab content item -->
                <div class="tab-pane" id="tab-7">
                  <div class="row">
                  <h5>General Surgery</h5>
                  </div>
                </div>
                <!-- End tab content item -->
                <div class="tab-pane" id="tab-8">
                  <div class="row">
                  <h5>Pregnancy</h5>
                  </div>
                </div>
                <!-- End tab content item -->
              </div>
            </div>
          </div>
          <!-- End doctors Section -->
        </div>
      </div>
    </div>
  </div>
</form>
@endsection @section('custom-js')
<script src="{{ asset('resources/vendor/sumo-select/jquery.sumoselect.min.js') }}"></script>
<!-- <script src="{{ asset('resources/datepicker/js/zebra_datepicker.min.js') }}"></script> -->
<script type="text/javascript">
 $(document).ready(function(){
  $(function () {
  $('#datepicker').datepicker();
  $('#datepicker').datepicker('show');
});
 })
</script>
<script type="text/javascript">
  const onSelect =()=>{
    document.getElementById('patient__form').style.display="block";
  }
</script>


<script type="text/javascript">
  $(document).ready(function() {
    (function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(onGeoSuccess, onGeoError);
      } else {
        alert("Your browser or device doesn't support Geolocation");
      }
    })();

    // If we have a successful location update
    function onGeoSuccess(event) {
      document.getElementById("latitude").value = event.coords.latitude;
      document.getElementById("longitude").value = event.coords.longitude;
    }

    // If something has gone wrong with the geolocation request
    function onGeoError(event) {
      alert("Error code " + event.code + ". " + event.message);
    }

    $(".select-sumo").SumoSelect({
      csvDispCount: 0,
      floatWidth: 400,
      search: true,
    });

    $("#selectSpeciality").change(function () {
      var sid = $(this).val();
      $("#clinicPanel").html("");
      $("#clinicTimePanel").html("");
      $("#clinicTab").attr("disabled", true);
      $("#patientTab").attr("disabled", true);

      $.ajax({
        url: "{!! url('book/doctor?sid=') !!}" + sid,
        type: "GET",
        error: function (xhr, status, error) {
          var status = xhr.status;
          var response = xhr.responseJSON;
        },
        beforeSend: function () {
          $("#showDoctor").html("");
        },
        success: function (data) {
          console.log(data);
          $("#showDoctor").html(data.data);
        },
      });
    });

    // select doctor
    $(document).on("click", ".btn-select-doctor", function (e) {
      e.preventDefault();
      $("[name=doctor]").val($(this).attr("data-docid"));
      $(this).find("[name=radio_select_doctor]").prop("checked", true);
      $("#clinicTab").attr("disabled", false);
    });

    // Select Clinic
    $(document).on("click", ".btn-select-clinic", function (e) {
      e.preventDefault();
      $("[name=clinic]").val($(this).attr("data-clinicid"));
      $(this).find("[name=radio_select_clinic]").prop("checked", true);
      $("#clinicTimePanel").html("");
      $("#patientTab").attr("disabled", false);
      $("#clinicTimeTab").attr("disabled", false);
    });

    // view more about doctor
    $(document).on("click", ".btn-view-more", function (e) {
      e.preventDefault();
      e.stopImmediatePropagation();
    });

    // view clinics
    $(document).on("click", "#clinicTab", function () {
      var doctorId = $("[name=doctor]").val();

      if ($("#clinicPanel").html() != "") {
        return;
      }

      $.ajax({
        url: "{!! url('book/doctor?view=clinic&doctor_id=') !!}" + doctorId,
        type: "GET",
        error: function (xhr, status, error) {
          var status = xhr.status;
          var response = xhr.responseJSON;
        },
        beforeSend: function () {
          $("#clinicPanel").html("");
        },
        success: function (data) {
          console.log(data);
          $("#clinicPanel").html(data.data);
        },
      });
    });

    // view clinic time
    $(document).on("click", "#clinicTimeTab", function () {
      var doctorId = $("[name=doctor]").val();
      var clinicId = $("[name=clinic]").val();

      if ($("#clinicTimePanel").html() != "") {
        return;
      }

      $.ajax({
        url:
          "{!! url('book/doctor?view=clinic-time&doctor_id=') !!}" +
          doctorId +
          "&clinic_id=" +
          clinicId,
        type: "GET",
        error: function (xhr, status, error) {
          var status = xhr.status;
          var response = xhr.responseJSON;
        },
        beforeSend: function () {
          $("#clinicTimePanel").html("");
        },
        success: function (data) {
          console.log(data);
          $("#clinicTimePanel").html(data.data);
        },
      });
    });

    // submit booking form
    $(document).on("submit", "#formBook", function (e) {
      e.preventDefault();

      var formData = new FormData(this);
      var error = $(".input-error");

      // clear all error message
      error.text("");

      $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: formData,
        contentType: false,
        processData: false,
        error: function (xhr, status, error) {
          var status = xhr.status;
          var response = xhr.responseJSON;
          console.log(response);
          if (response.message == "Validation Error") {
            $.each(response.data, function (index, element) {
              var errors = element.join(" ");
              var errorSpan = $("[data-for=" + index + "]");
              errorSpan.text(errors);
            });
          } else {
            Swal.mixin({
              toast: !0,
              position: "top-end",
              showConfirmButton: !1,
              timer: 1e3,
              timerProgressBar: !0,
              onOpen: function (t) {
                t.addEventListener("mouseenter", Swal.stopTimer),
                  t.addEventListener("mouseleave", Swal.resumeTimer);
              },
            }).fire({
              icon: "error",
              title: response.message ?? "",
            });
          }
        },
        statusCode: {
          401: function () {
            window.location.replace("{{ url('login') }}");
          },
        },
        beforeSend: function () {
          $("#btnBook").attr("disabled", true).text("Please wait");
        },
        success: function (data) {
          $("#bookingMessage").html(data.data);
          window.scrollTo(0, 0);
        },
        complete: function () {
          $("#btnBook").attr("disabled", false).text("Book Now");
        },
      });
    });
  });
</script>
@endsection
