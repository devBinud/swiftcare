<div class="col-6 col-md-4 col-lg-3 card-clinic-holder">
    <input type="hidden" name="doc_clinics[]" value="{{ $clinic->id }}">
    <div class="card card-clinic">
        <div class="card-body">
            <img src="{{ asset('storage/app/public/clinic/images/' . $clinic->thumbnail) }}" alt=""
                width="100%" height="150px">
            <p class="mt-2 mb-0">
                <span class="fw-bold">{{ $clinic->name }}</span> <br>
                <span style="font-size: 0.8em;">{{ $clinic->address }}</span>
            </p>
        </div>
        <div class="card-footer">
            <a href="{{ url(config('app.url_prefix.admin') . '/doctor?view_schedule=1&clinic=1&id=' . $doctorId . '&clinic_id=' . $clinic->id) }}"
                class="btn btn-outline-primary w-100 btn-schedule" target="_blank">Manage Schedule</a>
        </div>
        <i class="mdi mdi-close-circle text-danger btn-remove-clinic" data-id="{{ $clinic->id }}" style="font-size: 2em;"></i>
    </div>
</div>