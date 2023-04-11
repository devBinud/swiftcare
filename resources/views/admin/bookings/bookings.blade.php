@extends('admin.layout')
@section('title', 'Hospital')
@section('action-buttons')
    <a href="{{ url(config('app.url_prefix.admin') . '/hospital') }}" class="btn btn-outline-primary">
        <i class="fas fa-hospital mr-1"></i> View Hospital
    </a>
@endsection

@section('custom-css')
    <link href="{{ asset('resources/admin/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/sumo-select/sumoselect.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/admin/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        .input-error {
            color: red;
            font-size: 0.9em;
        }

        tr.fw-bold td {
            font-weight: bold;
        }

        tr.clickable:hover {
            cursor: pointer;
        }

        .booking-details-table th {
            font-weight: bold;
            padding: 2px;
            width: 25%;
        }

        .booking-details-table td {
            padding: 2px;
        }

        th,
        td {
            vertical-align: top !important;
        }
    </style>
@endsection

@section('body')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8">
                        <h4 class="fw-bold">Bookings</h4>
                    </div>
                    <div class="col-md-4 text-end d-none">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-filter"></i> Filter
                        </a>
                    </div>
                    <div class="col-12">
                        <form action="">
                            <div class="row">
                                <div class="col-md-2">
                                    <select name="service" class="form-select form-control" id="serviceSelect">
                                        <option value="" selected>All</option>
                                        <option value="Ambulance" @if (request()->get('service') == 'Ambulance') selected @endif>
                                            Ambulance</option>
                                        <option value="Hospital" @if (request()->get('service') == 'Hospital') selected @endif>Hospital
                                        </option>
                                        <option value="Doctor" @if (request()->get('service') == 'Doctor') selected @endif>Doctor
                                        </option>
                                        <option value="Lab Test" @if (request()->get('service') == 'Lab Test') selected @endif>Lab Test
                                        </option>
                                        <option value="Home Healthcare" @if (request()->get('service') == 'Home Healthcare') selected @endif>
                                            Home Healthcare</option>
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Booking ID, Patient name, phone, email"
                                            aria-label="Recipient's username" aria-describedby="button-addon2"
                                            value="{{ request()->get('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ url('admin/bookings') }}" class="btn btn-secondary w-100">
                                        <i class="mdi mdi-magnify-close"></i> Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="flexCheckDefault">
                                    </div>
                                </th>
                                <th></th>
                                <th>Booking ID</th>
                                <th>Patient Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th class="text-end">
                                    <select name="" class="form-select form-control" id="">
                                        <option value="" selected>With selected</option>
                                        <option value="">Mark as read</option>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $b)
                                <tr class="clickable booking-link @if ($b->is_read == 0) fw-bold @endif"
                                    data-bid="{{ $b->id }}" data-bs-toggle="modal"
                                    data-bs-target="#bookingDetailsModal"
                                    data-modaltitle="{{ $b->service }} booking for {{ $b->patient_name }}">
                                    <td>
                                        <input class="form-check-input" type="checkbox" value=""id="flexCheckDefault">
                                    </td>
                                    <td>
                                        @switch($b->service)
                                            @case('Ambulance')
                                                <img src="{{ asset('resources/icons/ambulance.svg') }}" width="20">
                                                {{-- <span class="badge rounded-pill badge-soft-secondary">{{ $b->service }}</span> --}}
                                            @break

                                            @case('Hospital')
                                                <img src="{{ asset('resources/icons/hospital.svg') }}" width="20">
                                                {{-- <span class="badge rounded-pill badge-soft-secondary">{{ $b->service }}</span> --}}
                                            @break

                                            @case('Doctor')
                                                <img src="{{ asset('resources/icons/doctor.svg') }}" width="20">
                                                {{-- <span class="badge rounded-pill badge-soft-secondary">{{ $b->service }}</span> --}}
                                            @break

                                            @case('Lab Test')
                                                <img src="{{ asset('resources/icons/lab_test.svg') }}" width="20">
                                                {{-- <span class="badge rounded-pill badge-soft-secondary">{{ $b->service }}</span> --}}
                                            @break

                                            @case('Home Healthcare')
                                                <img src="{{ asset('resources/icons/nurse.svg') }}" width="20">
                                                {{-- <span class="badge rounded-pill badge-soft-secondary">{{ $b->service }}</span> --}}
                                            @break
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ str_pad($b->id, 5, 0, STR_PAD_LEFT) }}
                                    </td>
                                    <td>
                                        {{ $b->patient_name }}
                                    </td>
                                    <td>{{ $b->phone }}</td>
                                    <td>{{ $b->address }}</td>
                                    <td class="text-end">
                                        <i class="dripicons-clock text-secondary" style="margin-right: 5px;"></i>
                                        {{ date('h:i A | M d, Y', strtotime($b->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <div class="row d-none">
                    <div class="col-3">
                        <div class="form-floating">
                            <select class="form-select" id="floatingSelectGrid" aria-label="Floating label select example">
                                <option value="">Mark as read</option>
                                <option value="">Delete</option>
                            </select>
                            <label for="floatingSelectGrid">With selected</label>
                        </div>
                    </div>
                </div>
                <div class="mt-5" id="paginationBox"></div>
            </div>
            <!--end card-header-->
            <div class="card-body">
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>

    <div class="modal fade" id="bookingDetailsModal" tabindex="-1" aria-labelledby="bookingDetailsModalTitle"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="bookingDetailsModalTitle"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body" id="bookingDetails">
                </div>
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>

    <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-labelledby="filePreviewModalTitle"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="filePreviewModalTitle"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body p-0" id="filePreview">
                    <iframe id="filePreviewFrame" src="" frameborder="0"
                        style="width:100%; height: 80vh;"></iframe>
                </div>
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>

@endsection

@section('custom-js')
    <script src="{{ asset('resources/admin/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/sumo-select/jquery.sumoselect.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('resources/admin/plugins/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.btn-file-preview', function(e) {
                e.preventDefault();

                $('#filePreviewModalTitle').text($(this).attr('data-modaltitle'));
                $('#filePreviewFrame').attr('src', $(this).attr('href'));
            });

            $('#serviceSelect').change(function() {
                $(this).parents('form').submit();
            });

            // pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $bookings->currentPage() }},
                totalPageCount: {{ ceil($bookings->total() / $bookings->perPage()) }},
                maxBtnCount: 10,
                align: "center",
                nextPrevBtnShow: true,
                firstLastBtnShow: true,
                prevPageName: "<",
                nextPageName: ">",
                lastPageName: "<<",
                firstPageName: ">>",
                callback: function(pageNumber) {
                    var params = "{!! request()->get('_url_params') !!}";
                    window.location.replace(
                        "{{ url(config('app.url_prefix.admin') . '/hospital?page=') }}" +
                        pageNumber + "&" +
                        params);
                },
            });

            $('.booking-link').click(function() {

                var bid = $(this).attr('data-bid');
                var modalTitle = $(this).attr('data-modaltitle');
                var tr = $(this);

                $('#bookingDetailsModalTitle').text(modalTitle);
                $('#bookingDetails').html('<h2>Please wait...</h2>');

                $.ajax({
                    url: "{{ url(config('app.url_prefix.admin') . '/bookings?id=') }}" + bid,
                    type: "GET",
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;

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
                            icon: "error",
                            title: response.message,
                        });
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {

                    },
                    success: function(data) {
                        tr.removeClass('fw-bold');
                        $('#bookingDetails').html(data.data);
                    },
                    complete: function() {

                    }
                });

            });

            // remark form
            $(document).on('submit', '.form-remark', function(e) {
                e.preventDefault();

                var form = $(this);
                var btnSubmit = $(this).find('.btn-submit');
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
                                var errorSpan = form.find('[name=' + index + ']')
                                    .siblings('.input-error');
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
                        btnSubmit.attr('disabled', true).text("Please wait");
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
                            window.location.replace(
                                "{{ url(config('app.url_prefix.admin') . '/bookings') }}"
                            );
                        });
                    },
                    complete: function() {
                        btnSubmit.attr('disabled', false).text("Submit Remark");
                    }
                });

            });

            // assign staff form
            $(document).on('submit', '.form-assign-staff', function(e) {
                e.preventDefault();

                var form = $(this);
                var btnSubmit = $(this).find('button[type=submit]');
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
                        var errMsg = "";

                        if (response.message == "Validation Error") {
                            $.each(response.data, function(index, element) {
                                var errors = element.join(" ");
                                errMsg += errors + "\n";
                            });
                        } else {
                            errMsg = response.message;
                        }

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
                            title: errMsg,
                        });
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        btnSubmit.attr('disabled', true).text("...");
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
                            window.location.replace(
                                "{{ url(config('app.url_prefix.admin') . '/bookings') }}"
                            );
                        });
                    },
                    complete: function() {
                        btnSubmit.attr('disabled', false).text("Assign");
                    }
                });

            });

        });
    </script>

@endsection
