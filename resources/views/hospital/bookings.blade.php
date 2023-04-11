@extends('hospital.layout')
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

        th {
            font-weight: bold !important;
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
                                    <select name="status" class="form-select form-control" id="statusSelect">
                                        <option value="" selected>All</option>
                                        <option value="Pending" @if (request()->get('status') == 'Pending') selected @endif>
                                            Pending</option>
                                        <option value="Visited" @if (request()->get('status') == 'Visited') selected @endif>Visited
                                        </option>
                                        <option value="Not Visited" @if (request()->get('status') == 'Not Visited') selected @endif>Not Visited
                                        </option>
                                        <option value="Cancelled" @if (request()->get('status') == 'Cancelled') selected @endif>Cancelled
                                        </option>
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
                                    <a href="{{ url('hospital/bookings') }}" class="btn btn-secondary w-100">
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
                                        <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                    </div>
                                </th>
                                <th>Booking ID</th>
                                <th>Patient Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th class="text-end">
                                    <select name="" class="form-select form-control" id="withSelected">
                                        <option value="" selected>With selected</option>
                                        <option value="Visited">Mark as visited</option>
                                        <option value="Not visited">Mark as not visited</option>
                                        <option value="Cancelled">Mark as cancelled</option>
                                    </select>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($bookings) > 0)
                                @foreach ($bookings as $b)
                                    <tr class="clickable" data-bid="{{ $b->id }}"
                                        data-modaltitle="{{ $b->service }} booking for {{ $b->patient_name }}">
                                        <td class="td-checkbox">
                                            <input class="form-check-input" name="check_booking[]" type="checkbox"
                                                value="{{ $b->id }}">
                                        </td>
                                        <td class="booking-link">
                                            {{ str_pad($b->id, 5, 0, STR_PAD_LEFT) }}
                                            @if (strtolower($b->status) == 'pending')
                                                <span class="badge rounded-pill bg-danger">New</span>
                                            @endif
                                        </td>
                                        <td class="booking-link">
                                            {{ $b->patient_name }}
                                        </td>
                                        <td class="booking-link">{{ $b->phone }}</td>
                                        <td class="booking-link">{{ $b->address }}</td>
                                        <td>
                                            <span
                                                class="badge rounded-pill 
                                                @switch($b->status)
                                                @case('Pending')
                                                    bg-warning
                                                    @break
                                                @case('Visited')
                                                    bg-success
                                                    @break
                                                @case('Not visited')
                                                bg-secondary
                                                    @break
                                                @case('Cancelled')
                                                bg-danger
                                                    @break
                                                @endswitch
                                                ">{{ $b->status }}</span>
                                        </td>
                                        <td class="booking-link text-end">
                                            <i class="dripicons-clock text-secondary" style="margin-right: 5px;"></i>
                                            {{ date('h:i A | d M, Y', strtotime($b->created_at)) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <h5 class="text-center text-danger">No booking record has been found</h5>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <hr>
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

            $('#statusSelect').change(function() {
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

            // view single booking
            $('.booking-link').click(function(e) {
                e.preventDefault();

                var bid = $(this).parent().attr('data-bid');
                var modalTitle = $(this).parent().attr('data-modaltitle');
                var tr = $(this);

                $('#bookingDetailsModal').modal('show');
                $('#bookingDetailsModalTitle').text(modalTitle);
                $('#bookingDetails').html('<h2>Please wait...</h2>');

                $.ajax({
                    url: "{{ url('hospital/bookings?id=') }}" + bid,
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

            // check bookings
            $('#checkAll').change(function(e) {
                if ($(this).is(':checked')) {
                    $('input[name="check_booking[]"]').prop('checked', true);
                } else {
                    $('input[name="check_booking[]"]').prop('checked', false);
                }
            });

            // with selected
            $('#withSelected').change(function() {

                var status = $(this).val();

                if (status == '') {
                    return;
                }

                var ids = [];

                $('input[name="check_booking[]"]:checked').each(function() {
                    ids.push($(this).val());
                });

                if (ids.length == 0 || !confirm(
                        "Are you sure you want to make changes to the selected items?")) {
                    return;
                }

                $.ajax({
                    url: "{{ url('hospital/bookings?action=update-status') }}",
                    type: $(this).attr('method'),
                    data: {
                        ids: ids,
                        status: status
                    },
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
                            timer: 3000,
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
                                "{{ url('hospital/bookings') }}"
                            );
                        });
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
