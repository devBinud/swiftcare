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
                <tr>
                    <td colspan="2">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span
                            class="badge rounded-pill 
                                @switch($hospital->status)
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
                                ">
                            {{ $hospital->status }}
                        </span>
                        @if ($hospital->status_updated_at != null)
                            <span class="ms-2" style="font-size: 0.8em;">
                                Last updated at
                                {{-- <i class="mdi mdi-clock-outline ms-2"></i> --}}
                                <span class="fw-bold">
                                    {{ date('h:i A | d M, y', strtotime($hospital->status_updated_at)) }}
                                </span>
                            </span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<hr>

@if ($data->prescription != null)
    <a class="btn btn-sm btn-primary btn-file-preview" data-modaltitle="Prescription of {{ $data->patient_name }}"
        href="{{ asset('storage/app/public/bookings/prescriptions/' . $data->prescription) }}" data-bs-toggle="modal"
        data-bs-target="#filePreviewModal">
        <i class="far fa-clipboard"></i>
        <span class="ml-3">View prescription</span>
    </a>
@endif
@if ($data->latitude != null && $data->longitude != null)
    <a class="btn btn-sm btn-primary" href="https://maps.google.com/?q={{ $data->latitude }},{{ $data->longitude }}"
        target="_blank">
        <i class="fas fa-map-marker-alt"></i> View on Google Map
    </a>
@endif

<script>
    $('.select-staff').SumoSelect({
        placeholder: 'Select Staff',
        csvDispCount: 0,
        floatWidth: 400,
        search: true,
    });
</script>
