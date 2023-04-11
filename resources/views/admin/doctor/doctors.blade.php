@extends('admin.layout')
@section('title', 'Doctors')
@section('page-title', request()->get('_page_title'))
@section('action-buttons')
    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
        <i class="far fa-hospital"></i> Add Doctor
    </a>
@endsection

@section('custom-css')

    <link href="{{ asset('resources/admin/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/sumo-select/sumoselect.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/vendor/material-time-picker/mdtimepicker.min.css') }}">

    <style>
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
            /* border: 1px solid lightblue; */
            box-shadow: 0px 0px 5px lightgrey;
        }

        .card-doctor .doctor-content {
            background: rgba(228, 248, 255, 0.3);
        }

        .doctor-name {
            color: brown;
            font-weight: bold;
        }

        .SumoSelect>.optWrapper>.options {
            max-height: 150px !important;
        }

        .card-doctor {
            position: relative !important;
        }

        .card-doctor .dropdown {
            position: absolute !important;
            right: 0;
            top: 0;
            display: block;
        }

        .clinic-list-view-container {
            position: relative;
            z-index: 10;
        }

        .clinic-list-view {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            max-height: 50vh;
            overflow-y: scroll;
        }

        .clinic-list-view .clinic-img {
            border-radius: 3px;
            overflow: hidden;
        }

        .assigned-clinic-card {
            position: relative;
        }

        .assigned-clinic-card .btn-remove-clinic {
            position: absolute;
            top: -10px;
            right: 0px;
            z-index: 1;
            font-size: 1.5em;
            cursor: pointer;
        }

        .card-clinic {
            position: relative;
        }

        .card-clinic .btn-remove-clinic {
            position: absolute;
            right: 0px;
            top: 0px;
            cursor: pointer;
        }
        
    </style>
@endsection

@section('body')
    <div class="container-fluid">
        <div class="row">
            @foreach ($doctors as $d)
                <div class="col-md-4 col-lg-2">
                    <div class="card card-doctor">
                        <div class="dropdown">
                            <a href="#" class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" data-title="{{ $d->name }}">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-more-horizontal align-self-center text-muted icon-xs">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="19" cy="12" r="1"></circle>
                                    <circle cx="5" cy="12" r="1"></circle>
                                </svg>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item edit-doctor" href="#" data-bs-toggle="modal"
                                    data-title="{{ $d->name }}" data-id="{{ $d->id }}"
                                    data-bs-target="#editDoctorModal" onclick="updateButtonTarget({{ $d->id }})">
                                    <i class="mdi mdi-pencil text-primary" style="margin-right: 5px;"></i>
                                    Edit
                                </a>
                                <a class="dropdown-item doctor-clinic" href="#" data-bs-toggle="modal"
                                    data-id="{{ $d->id }}" data-bs-target="#doctorClinicModal"
                                    data-title="{{ $d->name }}"
                                    onclick="clinicButtonTarget({{ $d->id }}, '{{ $d->clinic_ids }}')">
                                    <i class="mdi mdi-hospital-marker text-info" style="margin-right: 5px;"></i>
                                    Clinics
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="mdi mdi-delete-outline text-danger" style="margin-right: 5px;"></i>
                                    Delete
                                </a>
                            </div>
                        </div>
                        @if ($d->image != null)
                            <img src="{{ asset('storage/app/public/doctor/images/' . $d->image) }}" alt=""
                                class="doctor-img">
                        @else
                            <div class="doctor-img p-5 text-center">
                                @if ($d->gender == 'Female')
                                    <img src="{{ asset('resources/img/doctor_female.png') }}" alt="">
                                @else
                                    <img src="{{ asset('resources/img/doctor_male.png') }}" alt="">
                                @endif
                            </div>
                        @endif
                        <a href="#" class="edit-doctor" data-bs-toggle="modal" data-bs-target="#editDoctorModal"
                            data-id="{{ $d->id }}" data-title="{{ $d->name }}"
                            onclick="updateButtonTarget({{ $d->id }})">
                            <div class="doctor-content p-3">
                                <span class="doctor-name">Dr. {{ $d->name }}</span>
                                <div style="font-size: 0.8em;">
                                    {{ $d->qualification ?? '--' }} <br>
                                    {{ $d->specialities ?? '--' }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5" id="paginationBox"></div>
    </div>

    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalTitle" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="addDoctorModalTitle">Add Doctor</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body">
                    <form action="{{ url(config('app.url_prefix.admin') . '/doctor?action=add') }}" method="POST"
                        class="form-save-doctor" id="addDoctorForm">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input name="name" type="text" class="form-control"
                                                placeholder="Doctor Name" required>
                                            <label>Doctor Name</label>
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input name="phone" type="text" class="form-control"
                                                placeholder="Phone">
                                            <label>Phone</label>
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input name="email" type="text" class="form-control"
                                                placeholder="Email">
                                            <label>Email</label>
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-floating">
                                        <div class="form-floating mb-3">
                                            <select name="gender" class="form-select" id="floatingSelect"
                                                aria-label="Floating label select example" required>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <label for="floatingSelect">Gender</label>
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label class="mb-2">Specialities</label>
                                        <select name="specialities[]" class="select-sumo form-control"
                                            style="width: 100%; height:auto;" multiple>
                                            @if ($specialities != null)
                                                @foreach ($specialities as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <div class="input-error"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input name="qualification" type="text" class="form-control"
                                                placeholder="Qualification">
                                            <label>Qualification</label>
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input name="experience" type="number" maxlength="3" class="form-control"
                                                placeholder="Experience">
                                            <label>Experience in year</label>
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-floating mb-3">
                                            <input name="address" type="text" class="form-control"
                                                placeholder="Address">
                                            <label>Address</label>
                                            <div class="input-error"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Doctor Image</h5>
                                    </div>
                                    <div class="card-body">
                                        <input name="doctor_image" type="file" id="input-file-now" class="dropify" />
                                        <div class="input-error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="addDoctorForm" id="btnSubmit" class="btn btn-primary">Save
                        changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>

    <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalTitle"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="editDoctorModalTitle"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body" id="editDoctorModalBody">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnSaveChanges" class="btn btn-primary btn-submit">Save
                        changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>

    <div class="modal fade" id="doctorClinicModal" tabindex="-1" aria-labelledby="doctorClinicModalTitle"
        style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="doctorClinicModalTitle"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!--end modal-header-->
                <div class="modal-body" id="doctorClinicModalBody" style="min-height: 50vh;">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btnSaveClinic" class="btn btn-primary btn-save-clinic">Save
                        changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
                <!--end modal-body-->
            </div>
            <!--end modal-content-->
        </div>
        <!--end modal-dialog-->
    </div>

    <div class="d-none" id="appendAddMoreSchedule">
        <div class="col-md-4 time-schedule-card-holder">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Time from</label>
                            <input type="text" class="form-control time-picker-box">
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="">Time to</label>
                            <input type="text" class="form-control time-picker-box">
                        </div>
                        <div class="col-md-1 my-auto">
                            <i class="mdi mdi-close-circle-outline text-danger remove-time-schedule"
                                style="font-size: 1.5em; cursor: pointer;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('custom-js')

    <script src="{{ asset('resources/admin/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/vendor/sumo-select/jquery.sumoselect.min.js') }}"></script>
    <script src="{{ asset('resources/admin/assets/pages/jquery.form-upload.init.js') }}"></script>
    <script src="{{ asset('resources/vendor/material-time-picker/mdtimepicker.min.js') }}"></script>

    <script>
        var selectedClinicIds = [];

        function updateButtonTarget(id) {
            $('#btnSaveChanges').attr('form', 'addDoctorForm' + id);
        }

        function clinicButtonTarget(id, clinicIds) {
            selectedClinicIds = clinicIds == '' ? [] : clinicIds.split(',');
            $('#btnSaveClinic').attr('form', 'doctorClinicForm' + id);
        }

        function addMoreSchedule(scheduleId, clinicId) {
            return '<div class="col-md-4 time-schedule-card-holder">' +
                '<input type="hidden" name="schedule_id[' + clinicId + '][]"' +
                'value="' + scheduleId + '">' +
                '<div class="card">' +
                '<div class="card-body">' +
                '<div class="row">' +
                '<div class="col-md-6 form-group">' +
                '<label for="">Time from</label>' +
                '<input type="text" class="form-control time-picker-box"' +
                'name="time_from[' + clinicId + '][]"' +
                'value="">' +
                '</div>' +
                '<div class="col-md-5 form-group">' +
                '<label for="">Time to</label>' +
                '<input type="text" class="form-control time-picker-box"' +
                'name="time_to[' + clinicId + '][]"' +
                'value="">' +
                '</div>' +
                '<div class="col-md-1 my-auto">'
            '<i class="mdi mdi-close-circle-outline text-danger remove-time-schedule"' +
            'style="font-size: 1.5em; cursor: pointer;"></i>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
        }

        // prevent form submission on press ENTER
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(document).ready(function() {

            $('.select-sumo').SumoSelect({
                csvDispCount: 0,
                floatWidth: 400,
                search: true,
            });

            // edit doctor modal
            $('.edit-doctor').click(function() {

                var id = $(this).attr('data-id');
                $('#editDoctorModalTitle').text('Dr. ' + $(this).attr('data-title'));

                $.ajax({
                    url: "{{ url(config('app.url_prefix.admin') . '/doctor?id=') }}" + id,
                    type: "GET",
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;
                        console.log(response);
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        $('#editDoctorModalBody').html('');
                    },
                    success: function(data) {
                        $('#editDoctorModalBody').html(data.data);
                    }
                });
            });

            // doctor clinic modal
            $('.doctor-clinic').click(function() {

                var id = $(this).attr('data-id');
                $('#doctorClinicModalTitle').text('Clinics visited by Dr. ' + $(this).attr('data-title'));

                $.ajax({
                    url: "{!! url(config('app.url_prefix.admin') . '/doctor?clinic=1&id=') !!}" + id,
                    type: "GET",
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;
                        console.log(response);
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        $('#doctorClinicModalBody').html('');
                    },
                    success: function(data) {
                        $('#doctorClinicModalBody').html(data.data);
                    }
                });
            });

            // pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $doctors->currentPage() }},
                totalPageCount: {{ ceil($doctors->total() / $doctors->perPage()) }},
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
                        "{{ url(config('app.url_prefix.admin') . '/doctor?page=') }}" +
                        pageNumber +
                        "&" +
                        params);
                },
            });

            // doctor add form
            $(document).on('submit', '.form-save-doctor', function(e) {
                e.preventDefault();

                var form = $(this);
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
                                title: response.message,
                            });
                        }
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        $('.btn-submit').attr('disabled', true).text('Please wait');
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
                                "{{ url(config('app.url_prefix.admin') . '/doctor') }}"
                            );
                        });
                    },
                    complete: function() {
                        $('.btn-submit').attr('disabled', false).text('Save Changes');
                    }
                });

            });

            // search clinic
            $(document).on('keyup', '.input-search-clinic', function() {

                $('.clinic-list-view').html('');
                var search = $(this).val();

                if (search.length == 0) {
                    return;
                }

                var id = $(this).attr('data-id');

                $.ajax({
                    url: "{!! url(config('app.url_prefix.admin') . '/doctor?clinic=2&id=') !!}" + id + "&search=" + search,
                    type: "GET",
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;
                        console.log(response);
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        $('.clinic-list-view').html('');
                    },
                    success: function(data) {
                        console.log(data);
                        $('.clinic-list-view').html(data.data);
                    }
                });

            });

            // on select clinic
            $(document).on('click', '.btn-select-clinic', function() {

                var btn = $(this);
                var id = $(this).attr('data-id');
                var docId = $(this).attr('data-docid');

                if (selectedClinicIds.indexOf(id) === -1) {
                    selectedClinicIds.push(id);
                } else {
                    $('.input-search-clinic').val('');
                    $('.clinic-list-view').html('');
                    return;
                }

                $.ajax({
                    url: "{!! url(config('app.url_prefix.admin') . '/doctor?clinic=2&id=') !!}" + docId + "&selected_clinic=" + id,
                    type: "GET",
                    error: function(xhr, status, error) {
                        var status = xhr.status;
                        var response = xhr.responseJSON;
                        console.log(response);
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        btn.text('Wait..').attr('disabled', true);
                    },
                    success: function(data) {
                        console.log(data.data);
                        $('.clinic-row').append(data.data);
                    },
                    complete: function() {
                        btn.text('Select').attr('disabled', false);
                        $('.input-search-clinic').val('');
                        $('.clinic-list-view').html('');
                    }
                });

            });

            // doctor save sclinic form
            $(document).on('submit', '.doctor-save-clinic-form', function(e) {
                e.preventDefault();

                var form = $(this);
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
                            title: response.message,
                        });
                    },
                    statusCode: {
                        401: function() {
                            window.location.replace("{{ url('login') }}");
                        },
                    },
                    beforeSend: function() {
                        $('.btn-submit').attr('disabled', true).text('Please wait');
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
                                "{{ url(config('app.url_prefix.admin') . '/doctor') }}"
                            );
                        });
                    },
                    complete: function() {
                        $('.btn-submit').attr('disabled', false).text('Save Changes');
                    }
                });

            });

            // remove clinic
            $(document).on('click', '.btn-remove-clinic', function() {
                var clinicId = $(this).attr('data-id');
                $(this).parents('.card-clinic-holder').remove();
                selectedClinicIds = $.grep(selectedClinicIds, function(value) {
                    return value != clinicId;
                });
            });

            // remove time schedule
            $(document).on('click', '.remove-time-schedule', function() {
                $(this).parents('.time-schedule-card-holder').remove();
            });

        });
    </script>
@endsection
