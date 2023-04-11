<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login - Admin | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {{-- Prevent all search engines that support the noindex rule from indexing this page --}}
    <meta name="robots" content="noindex">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('resources/img/favicon.png') }}">

    <!-- App css -->
    <link href="{{ asset('resources/admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/admin/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="account-body accountbg">

    <!-- Log In page -->
    <div class="container">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="text-center mb-3">
                            <h2 class="fw-bold">
                                <img src="{{ asset('resources/img/favicon.png') }}" alt="" width="40">
                                {{ config('app.name') }}
                            </h2>
                        </div>
                        <div class="card"
                            style="border-radius: 5px; overflow: hidden; box-shadow: 0px 0px 5px rgba(128, 128, 128, 0.3);">
                            <div class="card-body p-0 auth-header-box p-3">
                                <div class="text-center">
                                    <h4 class="fw-semibold m-0 text-white font-18">Admin Login</h4>
                                    <p class="text-muted m-0">Sign in to continue to admin panel.</p>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active p-3" id="LogIn_Tab" role="tabpanel">
                                        <form class="form-horizontal auth-form" id="formLogin" action=""
                                            method="POST">
                                            @csrf
                                            <div class="form-group mb-2">
                                                <label class="form-label" for="username">Email or phone</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="phone_email"
                                                        id="phoneEmail" placeholder="Enter phone or email">
                                                </div>
                                            </div>
                                            <!--end form-group-->

                                            <div class="form-group mb-2">
                                                <label class="form-label" for="userpassword">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="password"
                                                        id="userpassword" placeholder="Enter password">
                                                </div>
                                            </div>
                                            <!--end form-group-->

                                            <div class="form-group row my-3">
                                                <div class="col-sm-6">
                                                    <div class="custom-control custom-switch switch-success">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customSwitchSuccess">
                                                        <label class="form-label text-muted"
                                                            for="customSwitchSuccess">Remember me</label>
                                                    </div>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end form-group-->

                                            <div class="form-group mb-0 row">
                                                <div class="col-12">
                                                    <button id="btnLogin"
                                                        class="btn btn-primary w-100 waves-effect waves-light"
                                                        type="submit">
                                                        <span class="spinner-border-sm" role="status"
                                                            aria-hidden="true" id="btnLoginSpinner"></span>
                                                        <span id="btnLoginText">Log In</span>
                                                        <i class="fas fa-sign-in-alt ms-1"></i>
                                                    </button>
                                                </div>
                                                <!--end col-->
                                            </div>
                                            <!--end form-group-->
                                        </form>
                                        <!--end form-->
                                    </div>
                                </div>
                            </div>
                            <!--end card-body-->
                            <div class="card-body bg-light-alt text-center">
                                <span class="text-muted d-none d-sm-inline-block">Mannatthemes ©
                                    <script>
                                        document.write(new Date().getFullYear())
                                    </script>
                                </span>
                            </div>
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
    <!-- End Log In page -->




    <!-- jQuery  -->
    <script src="{{ asset('resources/admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/waves.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('resources/admin/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            // login form submit
            $('#formLogin').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;

                        Swal.mixin({
                            toast: !0,
                            position: "top-end",
                            showConfirmButton: !1,
                            timer: 3e3,
                            timerProgressBar: !0,
                            onOpen: function(t) {
                                t.addEventListener("mouseenter", Swal
                                    .stopTimer), t.addEventListener(
                                    "mouseleave", Swal.resumeTimer);
                            },
                        }).fire({
                            icon: "error",
                            title: response.message,
                        });
                    },
                    statusCode: {},
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
                                t.addEventListener("mouseleave", Swal.resumeTimer);
                            },
                        }).fire({
                            icon: "success",
                            title: data.message,
                        }).then(function () {
                            window.location.replace("{{ url(config('app.url_prefix.admin') . '/') }}");
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


</body>

</html>
