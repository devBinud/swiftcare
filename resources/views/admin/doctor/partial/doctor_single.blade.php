<form action="{{ url(config('app.url_prefix.admin') . '/doctor?action=edit&id=' . $data->id) }}" method="POST"
    class="form-save-doctor" id="addDoctorForm{{ $data->id }}">
    @csrf
    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input name="name" type="text" class="form-control" placeholder="Doctor Name"
                            value="{{ $data->name }}" required>
                        <label>Doctor Name</label>
                        <div class="input-error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input name="phone" type="text" class="form-control" placeholder="Phone"
                            value="{{ $data->phone }}">
                        <label>Phone</label>
                        <div class="input-error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input name="email" type="text" class="form-control" placeholder="Email"
                            value="{{ $data->email }}">
                        <label>Email</label>
                        <div class="input-error"></div>
                    </div>
                </div>
                <div class="col-md-6 form-floating">
                    <div class="form-floating mb-3">
                        <select name="gender" class="form-select" id="floatingSelect"
                            aria-label="Floating label select example" required>
                            <option value="Male" @if ($data->gender == 'Male') selected @endif>Male</option>
                            <option value="Female" @if ($data->gender == 'Female') selected @endif>Female</option>
                            <option value="Other" @if ($data->gender == 'Other') selected @endif>Other</option>
                        </select>
                        <label for="floatingSelect">Gender</label>
                        <div class="input-error"></div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <label class="mb-2">Specialities</label>
                    <select name="specialities[]" class="select-sumo form-control" style="width: 100%; height:auto;"
                        multiple>
                        @if ($specialities != null)
                            @foreach ($specialities as $s)
                                <option value="{{ $s->id }}" @if (in_array($s->id, explode(',', $data->speciality_ids))) selected @endif>
                                    {{ $s->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="input-error"></div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input name="qualification" type="text" class="form-control" placeholder="Qualification"
                            value="{{ $data->qualification }}">
                        <label>Qualification</label>
                        <div class="input-error"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input name="experience" type="number" maxlength="3" class="form-control"
                            placeholder="Experience"
                            @if ($data->experience_from != null) value="{{ date('Y') - $data->experience_from }}" @endif>
                        <label>Experience in year</label>
                        <div class="input-error"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating mb-3">
                        <input name="address" type="text" class="form-control" placeholder="Address"
                            value="{{ $data->address }}">
                        <label>Address</label>
                        <div class="input-error"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Doctor Image</h5>
                </div>
                <div class="card-body">
                    <input name="doctor_image" type="file" id="input-file-now" class="dropify" />
                    <div class="input-error"></div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $('.select-sumo').SumoSelect({
        csvDispCount: 0,
        floatWidth: 400,
        search: true,
    });

    $('.dropify').dropify();
</script>

@if ($data->image != null)
    <script>
        $('.dropify').attr("data-default-file", "{{ asset('storage/app/public/doctor/images/' . $data->image) }}");
    </script>
@endif
