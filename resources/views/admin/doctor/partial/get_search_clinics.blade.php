@if (count($clinics) > 0)
    <div class="card">
        <table class="table">
            @foreach ($clinics as $c)
                <tr>
                    <td>
                        <div class="row w-100">
                            <div class="col-11">
                                <img class="clinic-img me-1"
                                    src="{{ asset('storage/app/public/clinic/images/' . $c->thumbnail) }}" alt=""
                                    width="30px;" height="30px;">
                                <span class="fw-bold clinic-name">{{ $c->name }}</span> |
                                <span class="clinic-address" style="font-size: 0.8em;">{{ $c->address }}</span>
                            </div>
                            <div class="col-1 text-end">
                                <button class="btn btn-sm btn-primary btn-select-clinic" data-docid="{{ $doctorId }}"
                                    data-id="{{ $c->id }}">Select</button>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
