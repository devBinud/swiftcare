<div class="row px-5">
    <input type="hidden" name="doctor">
    @foreach ($doctors as $d)
        <div class="col-md-4 col-lg-3">
            <button class="btn btn-select-doctor w-100 p-0" href="#" data-docid="{{ $d->id }}">
                <div class="card text-start">
                    <div class="card-body">
                        <input type="radio" name="radio_select_doctor">
                        @if ($d->image != null)
                            <img src="{{ asset('storage/app/public/doctor/images/' . $d->image) }}" alt=""
                                class="doctor-img">
                        @else
                            <div class="doctor-img p-5 text-center">
                                @if ($d->gender == 'Female')
                                    <img src="{{ asset('resources/img/doctor_female.png') }}" alt="">
                                @else
                                    <img src="{{ asset('resources/img/doctor_male.png') }}" alt="">
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-footer">
                        <span class="doctor-name">Dr. {{ $d->name }}</span>
                        <div style="font-size: 0.7em;">
                            <span class="text-dark">{{ $d->qualification ?? '--' }}</span> <br>
                            <span class="text-secondary">{{ $d->specialities ?? '--' }}</span>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <a href="#" class="btn btn-sm btn-secondary btn-view-more w-100" style="font-size: 0.8em;">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </button class="btn">
        </div>
    @endforeach
</div>
