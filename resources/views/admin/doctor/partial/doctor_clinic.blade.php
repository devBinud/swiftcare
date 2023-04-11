<div class="form-group clinic-list-view-container">
    <input type="text" class="form-control input-search-clinic" placeholder="Search" aria-label="Recipient's username"
        aria-describedby="button-addon2" data-id="{{ request()->get('id') }}">
    <div class="clinic-list-view">
    </div>
</div>

<form action="{{ url(config('app.url_prefix.admin') . '/doctor?action=edit-clinic') }}" class="doctor-save-clinic-form"
    id="doctorClinicForm{{ request()->get('id') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ request()->get('id') }}">
    <div class="row clinic-row">
        @foreach ($docClinics as $c)
            <div class="col-6 col-md-4 col-lg-3 card-clinic-holder">
                <input type="hidden" name="doc_clinics[]" value="{{ $c->id }}">
                <div class="card card-clinic">
                    <div class="card-body">
                        <img src="{{ asset('storage/app/public/clinic/images/' . $c->thumbnail) }}" alt=""
                            width="100%" height="150px">
                        <p class="mt-2 mb-0">
                            <span class="fw-bold">{{ $c->name }}</span> <br>
                            <span style="font-size: 0.8em;">{{ $c->address }}</span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{ url(config('app.url_prefix.admin') . '/doctor?view_schedule=1&clinic=1&id=' . $doctorId . '&clinic_id=' . $c->id) }}"
                            class="btn btn-outline-primary w-100 btn-schedule" target="_blank">Manage Schedule</a>
                    </div>
                    <i class="mdi mdi-close-circle text-danger btn-remove-clinic" data-id="{{ $c->id }}" style="font-size: 2em;"></i>
                </div>
            </div>
        @endforeach
    </div>

</form>
