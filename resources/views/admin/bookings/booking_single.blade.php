<div class="row">
    <div class="col-lg-6">
        <div class="table-responsive">
            <table class="table table-borderless booking-details-table">
                <tr>
                    <th>Booking ID</th>
                    <td>{{ str_pad($data->id, 5, 0, STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <th class="">Patient name</th>
                    <td>{{ $data->patient_name }}</td>
                </tr>
                <tr>
                    <th class="">Age</th>
                    <td>{{ $data->age ?? '' }}</td>
                </tr>
                <tr>
                    <th class="">Phone</th>
                    <td>{{ $data->phone }}</td>
                </tr>
                <tr>
                    <th class="">Email</th>
                    <td>{{ $data->email ?? '--' }}</td>
                </tr>
                <tr>
                    <th class="">Address</th>
                    <td>{{ $data->address }}</td>
                </tr>
                <tr>
                    <th>Booked at</th>
                    <td>
                        {{ date('h:i A | M d, Y', strtotime($data->created_at)) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="table-responsive">
            <table class="table table-borderless booking-details-table">
                <tr>
                    <td colspan="2">
                        @if ($data->prescription != null)
                            <a class="btn btn-outline-primary btn-file-preview"
                                data-modaltitle="Prescription of {{ $data->patient_name }}"
                                href="{{ asset('storage/app/public/bookings/prescriptions/' . $data->prescription) }}"
                                data-bs-toggle="modal" data-bs-target="#filePreviewModal">
                                <i class="far fa-clipboard"></i>
                                <span class="ml-3">View prescription</span>
                            </a>
                        @endif
                        @if ($data->latitude != null && $data->longitude != null)
                            <a class="btn btn-outline-primary"
                                href="https://maps.google.com/?q={{ $data->latitude }},{{ $data->longitude }}"
                                target="_blank">
                                <i class="fas fa-map-marker-alt"></i> View on Google Map
                            </a>
                        @endif
                    </td>
                </tr>

                @if ($data->service == 'Hospital' && $hospital != null)
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th>Hospital</th>
                        <td>{{ $hospital->hospital }}</td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td>{{ $hospital->department }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ date('M d, Y', strtotime($hospital->date)) }}</td>
                    </tr>
                    <tr>
                        <th>Time from</th>
                        <td>{{ date('h:i A', strtotime($hospital->time_from)) }}</td>
                    </tr>
                    <tr>
                        <th>Time to</th>
                        <td>{{ date('h:i A', strtotime($hospital->time_to)) }}</td>
                    </tr>
                @elseif ($data->service == 'Doctor' && $doctorBooking != null)
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="mdi text-secondary mdi-hospital-building"></i> Clinic</th>
                        <td>{{ $doctorBooking->clinic_name }}</td>
                    </tr>
                    <tr>
                        <th><i class="mdi text-secondary mdi-doctor"></i> Doctor</th>
                        <td>Dr. {{ $doctorBooking->doctor_name }}</td>
                    </tr>
                    <tr>
                        <th><i class="mdi text-secondary mdi-calendar-clock"></i> Appointment date</th>
                        <td>{{ date('d M, Y', strtotime($doctorBooking->booking_date)) }}</td>
                    </tr>
                    <tr>
                        <th><i class="mdi text-secondary mdi-clock-outline"></i> Time slot</th>
                        <td>{{ date('h:i A', strtotime($doctorBooking->time_from)) }} -
                            {{ date('h:i A', strtotime($doctorBooking->time_to)) }}</td>
                    </tr>
                @elseif ($data->service == 'Home Healthcare')
                    <tr>
                        <td colspan="2">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{-- <img src="{{ asset('resources/icons/illness.png') }}" class="me-1" width="17px;" alt=""> --}}
                            Health issue
                        </th>
                        <td>{{ $data->health_issue }}</td>
                    </tr>
                @endif
            </table>
        </div>

        @if ($data->service == 'Ambulance')
            <hr>
            <form class="form-assign-staff"
                action="{{ url(config('app.url_prefix.admin') . '/bookings?id=' . $data->id . '&assign_staff=1') }}"
                method="POST">
                @csrf
                <div class="row">
                    <div class="col-10 form-group m-0">
                        <label class="mb-2">Assign driver for ambulance</label>
                        <select name="staff[]" class="select-staff form-control" style="width: 100%; height:auto;"
                            multiple>
                            <option value="" disabled selected>Select</option>
                            @if ($drivers != null)
                                @foreach ($drivers as $d)
                                    <option value="{{ $d->id }}"
                                        @if (in_array($d->id, $assignedStaff)) selected @endif>{{ $d->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="input-error"></div>
                    </div>
                    <div class="col-2 mt-auto">
                        <button class="btn btn-primary" type="submit">Assign</button>
                    </div>
                </div>
            </form>
        @endif

    </div>
</div>

<hr>

<h4 class="fw-bold">Remark</h4>

<div class="table-responsive">
    <table class="table">
        <tbody>
            <tr>
                <td>
                    <form class="form-remark"
                        action="{{ url(config('app.url_prefix.admin') . '/bookings?save_remark=1') }}" method="POST">
                        @csrf
                        <div class="form-floating">
                            <textarea name="remark" class="form-control" placeholder="Remark on the booking" id="floatingTextarea2"></textarea>
                            <label for="floatingTextarea2">Leave your remark here</label>
                            <div class="input-error"></div>
                        </div>
                        <div class="form-floating">
                            <input type="hidden" name="booking_id" value="{{ $data->id }}">
                            <div class="input-error"></div>
                        </div>
                        <button class="btn btn-primary btn-submit mt-2 mb-3" class="btn btn-primary mt-2 mb-3">Submit
                            Remark</button>
                    </form>
                </td>
            </tr>
            @foreach ($remarks as $remark)
                <tr>
                    <td>
                        <blockquote class="blockquote">
                            <p>{{ $remark->remark }}</p>
                            <footer class="blockquote-footer" style="font-size: 0.8em !important;">
                                Remarked by <a href="">{{ $remark->remarked_by }}</a> at
                                {{ date('h:i a | M d, y', strtotime($remark->created_at)) }}
                            </footer>
                        </blockquote>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $('.select-staff').SumoSelect({
        placeholder: 'Select Staff',
        csvDispCount: 0,
        floatWidth: 400,
        search: true,
    });
</script>
