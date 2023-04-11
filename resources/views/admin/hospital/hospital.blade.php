@extends('admin.layout')
@section('title', 'Hospital')
@section('page-title', request()->get('_page_title'))
@section('action-buttons')
    <a href="{{ url(config('app.url_prefix.admin') . '/hospital?action=add') }}" class="btn btn-outline-primary">
        <i class="far fa-hospital"></i> Add Hospital
    </a>
@endsection

@section('custom-css')
    <style>
        .hospital-card {
            border-radius: 5px;
            overflow: hidden;
            /* border: 1px solid lightgrey; */
            transition: 0.3s;
        }

        .hospital-card:hover {
            box-shadow: 0px 0px 10px rgba(211, 211, 211, 1);
        }

        .hospital-img {
            width: 100%;
            height: 150px;
        }

        .hospital-details i {
            margin-right: 5px;
        }

        .id-icon {
            width: 10%;
            color: grey;
        }

        .td-value {
            width: 90%;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid">
        <div class="row">
            @foreach ($hospitals as $h)
                <div class="col-md-6 col-lg-3">
                    <div class="card hospital-card">
                        <img src="{{ asset('storage/app/public/hospital/images/' . $h->thumbnail) }}" alt=""
                            class="hospital-img">
                        <div class="card-body hospital-details">
                            <h5 class="fw-bold">
                                {{ $h->name }}
                                @if ($h->is_active != 1)
                                    <span class="badge rounded-pill bg-danger">Not Active</span>
                                @endif
                            </h5>
                            <table class="table-borderless">
                                <tr>
                                    <td class="id-icon"><i class="dripicons-location"></i></td>
                                    <td class="td-value">
                                        {{ substr($h->address, 0, 30) }}
                                        @if (strlen($h->address) > 30)
                                            ...
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="id-icon"><i class="dripicons-phone rotate-90"></i></td>
                                    <td class="td-value"><a class=""
                                            href="tel:{{ $h->phone }}">{{ $h->phone }}</a></td>
                                </tr>
                                <tr>
                                    <td class="id-icon"><i class="dripicons-mail"></i></td>
                                    <td class="td-value"><a href="mailto:{{ $h->email }}">{{ $h->email }}</a></td>
                                </tr>
                            </table>
                            {{-- <a href="https://maps.google.com/?q={{ $h->latitude }},{{ $h->longitude }}"
                                target="_blank">View on map</a> <br> --}}
                            <a href="{{ url(config('app.url_prefix.admin') . '/hospital?id=' . $h->id) }}" class="btn btn-outline-primary d-block mt-2">View More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="paginationBox"></div>
    </div>
@endsection

@section('custom-js')
    <script>
        $(document).ready(function() {

            // pagination
            $("#paginationBox").pxpaginate({
                currentpage: {{ $hospitals->currentPage() }},
                totalPageCount: {{ ceil($hospitals->total() / $hospitals->perPage()) }},
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
                    window.location.replace("{{ url(config('app.url_prefix.admin') . '/hospital?page=') }}" + pageNumber + "&" +
                        params);
                },
            });
        });
    </script>
@endsection
