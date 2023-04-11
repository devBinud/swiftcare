@extends('admin.layout')
@section('title', 'Clinic')
@section('action-buttons')
    <a href="{{ url(config('app.url_prefix.admin') . '/clinic') }}" class="btn btn-outline-primary">
        <i class="fas fa-hospital mr-1"></i> View Clinic
    </a>
@endsection

@section('custom-css')
    <style>
        .img-box {
            height: 200px;
            background-repeat: no-repeat;
            background-size: contain;
        }

        .clinic-table th,
        .clinic-table td {
            padding: 1px 3px !important;
        }

        .clinic-table th {
            width: 20%;
            font-weight: bold;
        }

        .doctor-img {
            width: 100%;
            height: 200px;
        }

        .card-doctor {
            border-radius: 5px;
            border: 1px solid transparent;
            transition: 0.2s;
            overflow: hidden;
        }

        .card-doctor:hover {
            border: 1px solid lightblue;
            box-shadow: 0px 0px 3px rgba(228, 248, 255, 0.3);
        }

        .card-doctor .doctor-content {
            background: rgba(228, 248, 255, 0.3);
        }

        .doctor-name {
            color: brown;
            font-size: 1.3em;
        }
    </style>
@endsection

@section('body')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="fw-bold">{{ $data->name }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        @if ($data->latitude != '' && $data->longitude != '' && $data->latitude != null && $data->longitude != null)
                            <a href="https://maps.google.com/?q={{ $data->latitude }},{{ $data->longitude }}"
                                class="btn btn-outline-info" target="_blank">
                                <i class="dripicons-map" style="margin-right: 5px;"></i> View on Google Map
                            </a>
                        @endif
                        <a href="{{ url(config('app.url_prefix.admin') . '/clinic') }}" class="btn btn-outline-primary">
                            <i class="fas fa-hospital mr-1"></i> View All Clinics
                        </a>
                    </div>
                </div>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="row">
                    <div class="col-4 col-lg-3 img-box"
                        style="background-image: url('{{ asset('storage/app/public/clinic/images/' . $data->thumbnail) }}');">
                    </div>
                    <div class="col-8 table-responsive">
                        <table class="table table-borderless clinic-table">
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($data->is_active == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Not Active</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>GSTIN</th>
                                <td>{{ strtoupper($data->gstin) }}</td>
                            </tr>
                            <tr>
                                <th>Contact person</th>
                                <td>{{ $data->contact_person }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>
                                    <a href="tel:{{ $data->phone }}">{{ $data->phone }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>
                                    <a href="mailto:{{ $data->email }}">{{ $data->email }}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td>{{ $data->address }}</td>
                            </tr>
                            <tr>
                                <th>Latitude</th>
                                <td>{{ $data->latitude }}</td>
                            </tr>
                            <tr>
                                <th>Longitude</th>
                                <td>{{ $data->longitude }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $data->username }}</td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td>********</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <h4 class="fw-bold">Doctors</h4>
                            </div>
                            <div class="col-md-8 text-end">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#addDoctorModal">
                                    <i class="fas fa-medkit" style="margin-right: 5px;"></i> Add Doctor
                                </button>
                            </div>
                        </div>
                    </div>
                    @for ($i = 0; $i < 3; $i++)
                        <div class="col-md-4 col-lg-3">
                            <a href="#">
                                <div class="card card-doctor">
                                    <img src="https://www.woodlandshospital.in/images/doctor-img/imran-ahmed.jpg"
                                        alt="" class="doctor-img">
                                    <div class="doctor-content p-3">
                                        <span class="doctor-name">Dr. Imran Ahmed</span> <br>
                                        MD, DM - Cardiology <br>
                                        Cardiology
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endfor
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6 text-start">
                        @if ($prev != null)
                            <a href="{{ url(config('app.url_prefix.admin') . '/clinic?id=' . $prev) }}"
                                class="btn btn-primary">
                                < Previous</a>
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        @if ($next != null)
                            <a href="{{ url(config('app.url_prefix.admin') . '/clinic?id=' . $next) }}"
                                class="btn btn-primary">Next ></a>
                        @endif
                    </div>
                </div>
            </div>
            <!--end card-body-->
        </div>
        <!--end card-->
    </div>

@endsection

@section('custom-js')

    <script>
        $(document).ready(function() {


        });
    </script>

@endsection
