<form action="" method="POST" id="formSaveSchedule">
    @csrf
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-justified" role="tablist">
                @php
                    $wCount = 0;
                @endphp
                @foreach ($weekdays as $w)
                    @if (in_array($w->id, explode(',', $schedule->week_day_ids)))
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link @if ($wCount == 0) active @endif"
                                data-bs-toggle="tab" href="#tabPanel{{ $schedule->clinic_id . $w->id }}" role="tab"
                                aria-selected="false">
                                {{ $w->name }},
                                @if ($w->week_day >= date('w'))
                                    {{ date('d M', strtotime(date('Y-m-d') . ' + ' . ($w->week_day - date('w')) . ' days')) }}
                                @else
                                    {{ date('d M', strtotime(date('Y-m-d') . ' + ' . (6 - date('w') + $w->week_day + 1) . ' days')) }}
                                @endif
                            </a>
                        </li>
                        @php
                            $wCount++;
                        @endphp
                    @endif
                @endforeach
            </ul>
            <div class="tab-content">
                @php
                    $wCount_ = 0;
                @endphp
                @foreach ($weekdays as $w)
                    @if (in_array($w->id, explode(',', $schedule->week_day_ids)))
                        <div class="tab-pane p-3 @if ($wCount_ == 0) active show @endif" id="tabPanel{{ $schedule->clinic_id . $w->id }}" role="tabpanel">
                            <div class="time-schedule-row">
                                @for ($i = 0; $i < count(explode(',', $schedule->week_day_ids)); $i++)
                                    @if ($w->id == explode(',', $schedule->week_day_ids)[$i])
                                        <input type="radio" class="btn-check" name="time_slot"
                                            id="schedule{{ explode(',', $schedule->schedule_ids)[$i] }}"
                                            value="{{ explode(',', $schedule->schedule_ids)[$i] }}" autocomplete="off">
                                        <label class="btn btn-outline-primary btn-sm"
                                            for="schedule{{ explode(',', $schedule->schedule_ids)[$i] }}">
                                            {{ date('h:i A', strtotime(explode(',', $schedule->time_from)[$i])) }} -
                                            {{ date('h:i A', strtotime(explode(',', $schedule->time_to)[$i])) }}
                                        </label>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @php
                            $wCount_++;
                        @endphp
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</form>
