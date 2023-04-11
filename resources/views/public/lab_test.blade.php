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
                    <h3 class='layer__para__second fw-medium'>Convenient Home Sample Collection for Accurate Diagnoses</h3>
                    <p class='layer__para__first'>
                    Skip the hassle of visiting a laboratory and let our healthcare professionals collect your samples at home. Receive accurate diagnoses and timely reports, all from the comfort of your own home.
                    </p>
                </div>
                <div class="form__wrapper bg-white">
                    <div class="row">
                        <div class="col-lg-7">
                            <form action="" class="p-lg-5 p-3 text-main" id="formBook" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control " id="floatingInput" placeholder="Enter Patient Name">
                                        <label for="name">Patient Name</label>
                                    </div>

                                    </div>
                                    <div class="col-lg-6 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control " id="phone" placeholder="Enter your Phone No">
                                        <label for="Phone">Phone No</label>
                                    </div>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control " id="age" placeholder="Enter your Age">
                                        <label for="age">Age</label>
                                    </div>
                                    </div>
                                    <div class="col-lg-6 py-2">
                                        <label for="formFileMultiple" class="form-label">Prescription</label>
                                         <input class="form-control" type="file" id="formFileMultiple" multiple>
                                    </div>
                                    <div class="col-lg-12 py-2">
                                    <div class="form-floating">
                                        <textarea class="form-control " placeholder="Your Address" id="address" style="height: 70px"></textarea>
                                        <label for="address">Address</label>
                                    </div>
                                    </div>
                                </div>
                                <input type="hidden" id="Latitude" name="latitude" readonly>
                                <input type="hidden" id="Longitude" name="longitude" readonly>
                                <button type="submit" id="btnBook" class="btn btn-primary px-4 my-4">
                                    <span class="spinner-border-sm" role="status" aria-hidden="true"
                                        id="btnBookSpinner"></span>
                                    <span id="btnBookText">Book Now</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-lg-5 order-2 order-lg-1 d-flex align-items-center justify-content-center">
                            <lottie-player src="{{ asset('resources/lottifiles/lab_test.json') }}"
                                background="transparent" speed="1" style="width: 60%; height: auto;" loop autoplay>
                            </lottie-player>
                        </div>
                    </div>
                </div>
                <div class="lower__layer__text py-2 d-none">
                    <p>*I agree that SwiftCare 24|7 representatives can contact me over call and SMS. I understand that
                        this will override the DND status on my mobile number.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-js')
<script>
        $(document).ready(function() {

            // submit form
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
                        $('#btnBook').attr('disabled', true).text("Please wait");
                    },
                    success: function(data) {
                        $('#bookingMessage').html(data.data);
                        window.scrollTo(0, 0);
                    },
                    complete: function() {
                        $('#btnBook').attr('disabled', false).text("Book Now");
                    }
                });

            });

        });
</script>
@endsection
