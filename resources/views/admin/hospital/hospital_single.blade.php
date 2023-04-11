@extends('admin.layout')
@section('title', 'Hospital')
@section('action-buttons')
    <a href="{{ url(config('app.url_prefix.admin') . '/hospital') }}" class="btn btn-outline-primary">
        <i class="fas fa-hospital mr-1"></i> View Hospital
    </a>
@endsection

@section('custom-css')
    <style>
        .img-box {
            height: 200px;
            background-repeat: no-repeat;
            background-size: contain;
        }

        .hospital-table th,
        .hospital-table td {
            padding: 3px !important;
        }

        .hospital-table th {
            width: 15%;
            font-weight: bold;
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
                        <a href="{{ url(config('app.url_prefix.admin') . '/hospital') }}" class="btn btn-outline-primary">
                            <i class="fas fa-hospital mr-1"></i> View All Hospitals
                        </a>
                    </div>
                </div>
            </div>
            <!--end card-header-->
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-lg-3 img-box"
                        style="background-image: url('{{ asset('storage/app/public/hospital/images/' . $data->thumbnail) }}');">
                    </div>
                    <div class="col-12 table-responsive">
                        <table class="table table-borderless hospital-table">
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
                                <th>Departments</th>
                                <td>
                                    @foreach (explode(',', $data->departments) as $d)
                                        <span class="badge rounded-pill bg-dark">{{ $d }}</span>
                                    @endforeach
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
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-6 text-start">
                        @if ($prev != null)
                            <a href="{{ url(config('app.url_prefix.admin') . '/hospital?id=' . $prev) }}"
                                class="btn btn-primary">
                                < Previous</a>
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        @if ($next != null)
                            <a href="{{ url(config('app.url_prefix.admin') . '/hospital?id=' . $next) }}"
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
