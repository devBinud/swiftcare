<div class="accordion-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Schedule</h4>
            <p class="text-muted mb-0">
                Manage doctor schedule for this clinic
            </p>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" role="tablist">
                @foreach ($weekdays as $w)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tabPanel{{ $schedule->clinic_id . $w->id }}"
                            role="tab" aria-selected="true">{{ $w->name }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content">
                @foreach ($weekdays as $w)
                    <div class="tab-pane p-3" id="tabPanel{{ $schedule->clinic_id . $w->id }}" role="tabpanel">
                        <div class="row time-schedule-row">

                            @if (in_array($w->id, explode(',', $schedule->week_day_ids)))
                                @for ($i = 0; $i < count(explode(',', $schedule->week_day_ids)); $i++)
                                    <div class="col-md-4 time-schedule-card-holder">
                                        <input type="hidden" name="schedule_id[{{ $schedule->clinic_id }}][]"
                                            value="{{ $schedule->id }}">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 form-group">
                                                        <label for="">Time from</label>
                                                        <input type="text" class="form-control time-picker-box"
                                                            name="time_from[{{ $schedule->clinic_id }}][]"
                                                            value="{{ explode(',', $schedule->time_from)[$i] }}">
                                                    </div>
                                                    <div class="col-md-5 form-group">
                                                        <label for="">Time to</label>
                                                        <input type="text" class="form-control time-picker-box"
                                                            name="time_to[{{ $schedule->clinic_id }}][]"
                                                            value="{{ explode(',', $schedule->time_to)[$i] }}">
                                                    </div>
                                                    <div class="col-md-1 my-auto">
                                                        <i class="mdi mdi-close-circle-outline text-danger remove-time-schedule"
                                                            style="font-size: 1.5em; cursor: pointer;"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                            <div class="col-12">
                                <button type="button" class="btn btn-sm btn-outline-primary btn-add-more-schedule"
                                    data-scheduleid="{{ $schedule->id }}" data-clinicid="{{ $schedule->clinic_id }}">+
                                    Add Schedule</button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    $('.time-picker-box').mdtimepicker();

    $(document).on('click', '.btn-add-more-schedule', function() {
        $(this).parent().parent().prepend(addMoreSchedule($(this).attr('data-scheduleid'), $(this).attr('data-clinicid')));
        $('.time-picker-box').mdtimepicker();
    });
</script>
