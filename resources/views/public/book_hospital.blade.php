@extends('public.layout')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('resources/css/booking.css') }}">
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
    </style>
@endsection


@section('body')
    <div class="banner">
        <div class="content__wrapper">
            <div class="container">
                <div class="upper__layer__text py-3">
                    <h4 class='layer__para__first'>We’ll Help You Get Through</h4>
                    <h3 class='layer__para__second fw-medium'>Bringing Care, Hope, and Excellence</h3>
                    <p class='layer__para__last'>Living Life with Lights & Sirens Blaring</p>
                </div>
                <div class="form__wrapper bg-white">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="" class="p-lg-5 p-3 text-main" id="formBook" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-4 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control " id="floatingInput" placeholder="Enter Patient Name">
                                        <label for="name">Patient Name</label>
                                    </div>
                                    </div>
                                    <div class="col-lg-4 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="Phone No" class="form-control " id="phone" placeholder="Enter your Phone No">
                                        <label for="Phone">Phone No</label>
                                    </div>
                                    </div>
                                    <div class="col-lg-4 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control " id="age" placeholder="Enter your Age">
                                        <label for="Age">Age</label>
                                    </div>
                                    </div>
                                    <div class="col-lg-10 py-2">
                                    <div class="form-floating">
                                        <textarea class="form-control " placeholder="Your Address" id="address" style="height: 70px"></textarea>
                                        <label for="address">Address</label>
                                    </div>
                                    <div class="input-error"></div>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <!-- <div class="form-group">
                                            <label for="exampleInputEmail" class="pb-2">Hospital <span class="text-main">
                                                    *</span></label>
                                            <select name="hospital"
                                                class="form-select rounded-pill shadow-none text-secondary"
                                                aria-label="Default select example" style="padding: 10px;">
                                                <option value="">Please select</option>
                                                @foreach ($hospitals as $h)
                                                    <option value="{{ $h->id }}">{{ $h->name }}
                                                        ({{ substr($h->address, 0, 20) }}...)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-error"></div>
                                        </div> -->
                                            <div class="form-floating">
                                                <select class="form-select shadow-none " id="floatingSelect" aria-label="Floating label select example">
                                                    <option selected>Please select</option>
                                                    <option value="1">Narayana Hospital</option>
                                                    <option value="2">Apollo Hospital</option>
                                                    <option value="3">Dispur Hospital</option>
                                                </select>
                                                <label for="floatingSelect">Preferred Hospital</label>
                                                <div class="input-error"></div>
                                            </div>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                    <div class="form-floating">
                                                <select class="form-select shadow-none " id="floatingSelect" aria-label="Floating label select example">
                                                    <option selected>Please select</option>
                                                    <option value="1">Department 01</option>
                                                    <option value="2">Department 02</option>
                                                    <option value="3">Department 03</option>
                                                </select>
                                                <label for="floatingSelect">Departments</label>
                                                <div class="input-error"></div>
                                            </div>
                                    </div>
                                    <div class="col-lg-4 py-2">
                                        <div class="form-group">
                                            <label for="exampleInputEmail" class="pb-2">Date <span class="text-main">
                                                    *</span></label>
                                            <input type="date" name="date"
                                                class="form-control form-control-lg" id="exampleInputName"
                                                placeholder="Enter date">
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 py-2">
                                        <div class="form-group">
                                            <label for="exampleInputEmail" class="pb-2">Time from</label>
                                            <input type="time" name="time_from"
                                                class="form-control form-control-lg" id="exampleInputName"
                                                placeholder="Time from">
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 py-2">
                                        <div class="form-group">
                                            <label for="exampleInputEmail" class="pb-2">Time to</label>
                                            <input type="time" name="time_to"
                                                class="form-control form-control-lg " id="exampleInputName"
                                                placeholder="Time to">
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="Latitude" name="latitude" readonly>
                                <input type="hidden" id="Longitude" name="longitude" readonly>
                                <button type="submit" id="btnBook"
                                    class="btn btn-primary px-4 my-4">
                                    <span class="spinner-border-sm" role="status" aria-hidden="true"
                                        id="btnBookSpinner"></span>
                                    <span id="btnBookText">Book Now</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-lg-5 order-2 order-lg-1 d-none">
                            <lottie-player src="{{ asset('resources/lottifiles/bookHospital.json') }}"
                                background="transparent" speed="1" style="width: 100%; height: 100%;" loop autoplay>
                            </lottie-player>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
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
                document.getElementById("Latitude").value = event.coords.latitude;
                document.getElementById("Longitude").value = event.coords.longitude;

            }

            // If something has gone wrong with the geolocation request
            function onGeoError(event) {
                alert("Error code " + event.code + ". " + event.message);
            }

            // on hospital change
            $('select[name=hospital]').change(function() {

                var hid = $(this).val();

                $.ajax({
                    url: "{{ url('api/master/departments?hid=') }}" + hid,
                    type: "GET",
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;
                        if (response.message == "Validation Error") {
                            $.each(response.data, function(index, element) {
                                var errors = element.join(" ");
                                var errorSpan = $('[name=' + index + ']').parents(
                                    '.form-group').find('.input-error');
                                errorSpan.text(errors);
                            });
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        $('select[name=department]').html(
                            '<option value="">Please select</option>');
                    },
                    success: function(data) {
                        console.log(data);
                        $.each(data.data, function(index, element) {
                            $('select[name=department]').append('<option value="' +
                                element.id + '">' + element.department + '</option>'
                            )
                        });
                    },
                    complete: function() {}
                });

            });

            // submit hospital add form
            $('#formBook').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var error = $('.input-error');

                // clear all error message
                error.text('');

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;

                        if (response.message == "Validation Error") {
                            $.each(response.data, function(index, element) {
                                var errors = element.join(" ");
                                var errorSpan = $('[name=' + index + ']').parents(
                                    '.form-group').find('.input-error');
                                errorSpan.text(errors);
                            });
                        } else {
                            Swal.mixin({
                                toast: !0,
                                position: "top-end",
                                showConfirmButton: !1,
                                timer: 1e3,
                                timerProgressBar: !0,
                                onOpen: function(t) {
                                    t.addEventListener("mouseenter", Swal
                                            .stopTimer),
                                        t.addEventListener("mouseleave", Swal
                                            .resumeTimer);
                                },
                            }).fire({
                                icon: "error",
                                title: response.message ?? "",
                            });
                        }
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        $('#btnBook').attr('disabled', true);
                        $('#btnBookText').text('Please wait');
                        $('#btnBookSpinner').addClass('spinner-border');
                    },
                    success: function(data) {
                        Swal.mixin({
                            toast: !0,
                            position: "top-end",
                            showConfirmButton: !1,
                            timer: 1e3,
                            timerProgressBar: !0,
                            onOpen: function(t) {
                                t.addEventListener("mouseenter", Swal
                                        .stopTimer),
                                    t.addEventListener("mouseleave", Swal
                                        .resumeTimer);
                            },
                        }).fire({
                            icon: "success",
                            title: data.message ?? "",
                        }).then(function() {
                            window.location.replace("{{ url('/') }}");
                        });
                    },
                    complete: function() {
                        $('#btnBook').attr('disabled', false);
                        $('#btnBookText').text('Book Now');
                        $('#btnBookSpinner').removeClass('spinner-border');
                    }
                });

            });

        });
    </script>
@endsection
