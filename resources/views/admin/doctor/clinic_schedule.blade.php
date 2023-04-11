@extends('admin.layout')
@section('title', 'Doctor Clinic Schedule')


@section('custom-css')

    <link href="{{ asset('resources/admin/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet">
    <link href="{{ asset('resources/vendor/sumo-select/sumoselect.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resources/vendor/material-time-picker/mdtimepicker.min.css') }}">

@endsection

@section('body')
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Doctor</div>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('storage/app/public/doctor/images/' . $doctor->image) }}" alt=""
                                    width="100%" height="150px">
                            </div>
                            <div class="card-footer">
                                <span class="">Dr. {{ $doctor->name }}</span>
                                {{-- <span style="font-size: 0.8em;">
                                    @if ($doctor->qualification != null && $doctor->qualification != '')
                                        <br>
                                        {{ $doctor->qualification }}
                                    @endif --}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">Clinic</div>
                            </div>
                            <div class="card-body">
                                <img src="{{ asset('storage/app/public/clinic/images/' . $clinic->thumbnail) }}"
                                    alt="" width="100%" height="150px">
                            </div>
                            <div class="card-footer">
                                <span class="">{{ $clinic->name }}</span>
                                {{-- <span style="font-size: 0.8em;">
                                    @if ($clinic->address != null && $clinic->address != '')
                                        <br>
                                        {{ $clinic->address }}
                                    @endif
                                </span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <form action="" method="POST" id="formSaveSchedule">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Manage Schedule for <span class="text-dark">Dr.
                                    {{ $doctor->name }}</span>
                                at <span class="text-dark">{{ $clinic->name }}</span></div>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach ($weekdays as $w)
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab"
                                            href="#tabPanel{{ $schedule->clinic_id . $w->id }}" role="tab"
                                            aria-selected="true">{{ $w->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="tab-content">
                                @foreach ($weekdays as $w)
                                    <div class="tab-pane p-3" id="tabPanel{{ $schedule->clinic_id . $w->id }}"
                                        role="tabpanel">
                                        <div class="row time-schedule-row">
                                            @for ($i = 0; $i < count(explode(',', $schedule->week_day_ids)); $i++)
                                                @if ($w->id == explode(',', $schedule->week_day_ids)[$i])
                                                    <div class="col-md-6 time-schedule-card-holder">
                                                        <input type="hidden" name="schedule_id[]"
                                                            value="{{ $schedule->id }}">
                                                        <input type="hidden" name="week_day_id[]"
                                                            value="{{ $w->id }}">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6 form-group">
                                                                        <label for="">Time from</label>
                                                                        <input type="time" class="form-control"
                                                                            name="time_from[]"
                                                                            value="{{ date('H:i', strtotime(explode(',', $schedule->time_from)[$i])) }}">
                                                                    </div>
                                                                    <div class="col-md-5 form-group">
                                                                        <label for="">Time to</label>
                                                                        <input type="time" class="form-control"
                                                                            name="time_to[]"
                                                                            value="{{ date('H:i', strtotime(explode(',', $schedule->time_to)[$i])) }}">
                                                                    </div>
                                                                    <div class="col-md-1 my-auto">
                                                                        <i class="mdi mdi-close-circle-outline text-danger remove-time-schedule"
                                                                            style="font-size: 1.5em; cursor: pointer;"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endfor
                                            <div class="col-12">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary btn-add-more-schedule"
                                                    data-weekdayid="{{ $w->id }}">+
                                                    Add Schedule</button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button class="btn btn-primary">Save schedule</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="d-none" id="appendAddMoreSchedule">
        <div class="col-md-6 time-schedule-card-holder">
            <input type="hidden" name="schedule_id[]">
            <input type="hidden" name="week_day_id[]">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="">Time from</label>
                            <input type="time" class="form-control" name="time_from[]">
                        </div>
                        <div class="col-md-5 form-group">
                            <label for="">Time to</label>
                            <input type="time" class="form-control" name="time_to[]">
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
        // prevent form submission on press ENTER
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $(document).ready(function() {

            $('.time-picker-box').mdtimepicker();

            $(document).on('click', '.btn-add-more-schedule', function() {
                var data = $('#appendAddMoreSchedule').html();
                $('#appendAddMoreSchedule').find('input[name="week_day_id[]"]').val($(this).attr(
                    'data-weekdayid'));
                $(this).parent().parent().prepend($('#appendAddMoreSchedule').html());
                $('#appendAddMoreSchedule').html(data);
                $('.time-picker-box').mdtimepicker();
            });

            $('.select-sumo').SumoSelect({
                csvDispCount: 0,
                floatWidth: 400,
                search: true,
            });

            // remove time schedule
            $(document).on('click', '.remove-time-schedule', function() {
                $(this).parents('.time-schedule-card-holder').remove();
            });

            // save schedule
            $('#formSaveSchedule').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                var url = $(this).attr('action');
                var type = $(this).attr('method');

                $.ajax({
                    url: url,
                    type: type,
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
                            title: data.message,
                        }).then(function() {
                            window.location.reload();
                        });
                    }
                });

            });

        });
    </script>
@endsection
