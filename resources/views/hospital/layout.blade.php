<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        @hasSection('title')
            @yield('title') | {{ config('app.name') }}
        @else
            Hospital | {{ config('app.name') }}
        @endif
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('resources/img/favicon.png') }}">

    <!-- jvectormap -->
    <link href="{{ asset('resources/admin/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('resources/admin/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/admin/assets/css/metisMenu.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/admin/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('resources/admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('resources/admin/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="{{ asset('resources/vendor/generic-px-pagination/px-pagination.css') }}">

    <style>
        .form-control:not([required])~label::after {
            content: ' (Optional)';
            color: lightgray;
        }

        .SumoSelect {
            width: 100% !important;
        }

        .rotate-90 {
            display: inline-block;
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            transform: rotate(90deg);
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            margin: 0 !important;
        }

        .input-error {
            color: red;
            font-size: 0.8em;
        }
    </style>

    @yield('custom-css')

</head>

<body class="">
    <!-- Left Sidenav -->
    <div class="left-sidenav bg-light">
        <div class="menu-content h-100" data-simplebar>
            <ul class="metismenu left-sidenav-menu">
                <li>
                    <a href="{{ url('hospital/') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('hospital/bookings') }}"
                        class="@if (request()->get('module') == 'bookings') text-primary @endif">
                        <i class="fas fa-calendar-check @if (request()->get('module') == 'bookings') text-primary @endif"></i>
                        <span>Bookings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('hospital/profile') }}"
                        class="@if (request()->get('module') == 'bookings') text-primary @endif">
                        <i class="mdi mdi-hospital-building @if (request()->get('module') == 'bookings') text-primary @endif"></i>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- end left-sidenav-->

    <div class="page-wrapper">
        <!-- Top Bar Start -->
        <div class="topbar">
            <!-- Navbar -->
            <nav class="navbar-custom">
                <ul class="list-unstyled topbar-nav float-end mb-0">
                    @if (request()->get('_unread_bookings') > 0)
                        <li class="dropdown">
                            <a href="{{ url('hospital/bookings') }}" class="nav-link">
                                <span
                                    class="badge rounded-pill bg-danger">{{ request()->get('_unread_bookings') }}</span>
                                Pending Bookings
                            </a>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a class="nav-link" href="{{ url('hospital/logout') }}"><i data-feather="power"
                                class="align-self-center text-danger icon-xs icon-dual me-1"></i>
                            Logout</a>
                    </li>
                </ul>
                <!--end topbar-nav-->

                <ul class="list-unstyled topbar-nav mb-0">
                    <li>
                        <button class="nav-link button-menu-mobile">
                            <i data-feather="menu" class="align-self-center topbar-icon"></i>
                        </button>
                    </li>
                    <li class="nav-link">
                        <img src="{{ asset('resources/img/favicon.png') }}" alt="" width="20">
                        <span class="fw-bold text-dark" style="font-size: 1.2em;">{{ config('app.name') }}</span>
                    </li>
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->

        <!-- Page Content-->
        <div class="page-content" style="background: rgb(245, 245, 245);">
            <div class="container-fluid py-3">
                @hasSection('page-title')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        <h4 class="page-title">
                                            @yield('page-title')
                                        </h4>
                                    </div>
                                    <!--end col-->
                                    <div class="col-auto">
                                        @hasSection('action-buttons')
                                            @yield('action-buttons')
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @yield('body')
            </div><!-- container -->

            <footer class="footer text-center text-sm-start">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script> {{ config('app.name') }} <span
                    class="text-muted d-none d-sm-inline-block float-end">
                    Developed by
                    <a href="https://codepilot.in" target="_blank">Codepilot Technologies Pvt. Ltd.</a>
                </span>
            </footer>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->

    <!-- jQuery  -->
    <script src="{{ asset('resources/admin/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/metismenu.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/waves.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/js/moment.js') }}"></script>
    <script src="{{ asset('resources/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('resources/admin/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('resources/admin/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('resources/admin/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/pages/jquery.analytics_dashboard.init.js') }}"></script>

    <script src="{{ asset('resources/admin/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('resources/admin/assets/js/app.js') }}"></script>

    <script src="{{ asset('resources/vendor/generic-px-pagination/px-pagination.js') }}"></script>

    @yield('custom-js')

</body>

</html>
