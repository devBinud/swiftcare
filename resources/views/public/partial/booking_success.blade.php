<div class="row">
    <div class="col-4 mx-auto">
        <lottie-player src="{{ asset('resources/lottifiles/successful.json') }}" background="transparent" speed="1"
            style="width: 100%; height: 150px;" autoplay></lottie-player>
    </div>
    <div class="col-12 text-center">
        <h2 class="fw-bold my-0 text-success" style="font-size: 3em;">Thank you</h2>
        <h4 class="fw-light">Your request for {{ $service }} has been submitted successfully</h4>
        <p class="fw-bold" style="line-height: 1em;">Reference ID: <span class="fw-bold">{{ $referenceId }}</span></p>
    </div>
    <div class="col-8 mx-auto fw-light text-center" style="line-height: 1em">
        Kindly wait. Please keep the reference ID for use in the future. Our executives will respond to you as soon as
        possible.
    </div>
</div>
