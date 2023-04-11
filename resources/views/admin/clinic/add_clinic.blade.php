@extends('admin.layout')
@section('title', 'Clinic')
@section('action-buttons')
    <a href="{{ url(config('app.url_prefix.admin') . '/clinic') }}" class="btn btn-outline-primary">
        <i class="fas fa-hospital mr-1"></i> View Clinics
    </a>
@endsection

@section('custom-css')
    <link href="{{ asset('resources/admin/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/sumo-select/sumoselect.min.css') }}" rel="stylesheet">

    <style>
        .error {
            color: red;
            font-size: 0.9em;
            line-height: 0px;
        }
        .SumoSelect {
            width: 100%;
        }
    </style>
@endsection

@section('body')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="fw-bold">Add New Clinic</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ url(config('app.url_prefix.admin') . '/hospital') }}" class="btn btn-outline-primary">
                            <i class="fas fa-hospital mr-1"></i> View Clinics
                        </a>
                    </div>
                </div>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <form action="" method="post" id="formAddClinic" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="actioon" value="add">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="fw-bold">Basic Details</h6>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <input name="clinic_name" type="text" class="form-control" id="flotingInput"
                                    placeholder="Enter name of the clinic" required>
                                <label for="flotingInput">Clinic Name</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <input name="gstin" type="text" class="form-control" id="flotingInput"
                                    placeholder="Enter GSTIN" required>
                                <label for="flotingInput">GSTIN</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <input name="contact_person" type="text" class="form-control" id="flotingInput"
                                    placeholder="Contact person" required>
                                <label for="flotingInput">Contact person</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <input name="phone" type="text" class="form-control" id="flotingInput"
                                    placeholder="Phone" required>
                                <label for="flotingInput">Phone</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control" id="flotingInput"
                                    placeholder="Email">
                                <label for="flotingInput">Email</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <input name="latitude" type="text" class="form-control" id="flotingInput"
                                    placeholder="Latitude">
                                <label for="flotingInput">Latitude</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <input name="longitude" type="text" class="form-control" id="flotingInput"
                                    placeholder="Longitude">
                                <label for="flotingInput">Longitude</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="form-floating mb-3">
                                <select name="status" class="form-select" id="floatingSelect"
                                    aria-label="Floating label select example">
                                    <option value="1">Active</option>
                                    <option value="0">Deactive</option>
                                </select>
                                <label for="floatingSelect">Status</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input name="address" type="text" class="form-control" id="flotingInput"
                                    placeholder="Address" required>
                                <label for="flotingInput">Address</label>
                                <div class="error"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6 class="fw-bold">Clinic Image (Thumbnail)</h6>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <input name="thumbnail" type="file" id="input-file-now"
                                                    class="dropify" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h6 class="fw-bold">Authentication Details</h6>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input name="username" type="text" class="form-control"
                                                        id="flotingInput" placeholder="Username" required>
                                                    <label for="flotingInput">Username</label>
                                                    <div class="error"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input name="password" type="password" class="form-control"
                                                        id="flotingInput" placeholder="Username" required
                                                        autocomplete="new-password">
                                                    <label for="flotingInput">Password</label>
                                                    <div class="error"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button id="btnSubmit" class="btn btn-primary waves-effect waves-light" type="submit">
                                <span class="spinner-border-sm" role="status" aria-hidden="true"
                                    id="btnSubmitSpinner"></span>
                                <span id="btnSubmitText">Save Clinic</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>
@endsection

@section('custom-js')
    <script src="{{ asset('resources/admin/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/sumo-select/jquery.sumoselect.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/pages/jquery.form-upload.init.js') }}"></script>

    <script>
        $(document).ready(function() {

            // submit hospital add form
            $('#formAddClinic').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var error = $('.error');

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
                                    '.form-floating').find('.error');
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
                        $('#btnLogin').attr('disabled', true);
                        $('#btnLoginText').text('Please wait');
                        $('#btnLoginSpinner').addClass('spinner-border');
                    },
                    success: function(data) {
                        Swal.mixin({
                            toast: !0,
                            position: "top-end",
                            showConfirmButton: !1,
                            timer: 1e3,
                            timerProgressBar: !0,
                            onOpen: function(t) {
                                t.addEventListener("mouseenter", Swal.stopTimer),
                                    t.addEventListener("mouseleave", Swal
                                        .resumeTimer);
                            },
                        }).fire({
                            icon: "success",
                            title: data.message,
                        }).then(function() {
                            window.location.replace("{{ url(config('app.url_prefix.admin') . '/clinic') }}");
                        });
                    },
                    complete: function() {
                        $('#btnLogin').attr('disabled', false);
                        $('#btnLoginText').text('Log In');
                        $('#btnLoginSpinner').removeClass('spinner-border');
                    }
                });

            });

        });
    </script>

@endsection
