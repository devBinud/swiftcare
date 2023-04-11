<div class="row py-4">
    <input type="hidden" name="clinic">
    @foreach ($clinics as $c)
        <div class="col-md-4 col-lg-3">
            <button class="btn btn-select-clinic w-100 p-0" href="#" data-clinicid="{{ $c->id }}">
                <div class="card text-start">
                    <div class="card-body">
                        <input type="radio" name="radio_select_clinic">
                        <img src="{{ asset('storage/app/public/clinic/images/' . $c->thumbnail) }}" alt=""
                            class="doctor-img">
                    </div>
                    <div class="card-footer">
                        <span class="doctor-name">{{ $c->name }}</span>
                        <div style="font-size: 0.7em;">
                            <span class="text-secondary">{{ $c->address ?? '--' }}</span>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="#" class="btn btn-sm btn-secondary btn-view-more w-100"
                                    style="font-size: 0.8em;">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </button class="btn">
        </div>
    @endforeach
</div>
