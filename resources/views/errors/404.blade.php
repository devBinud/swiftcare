@extends('public.layout', [
    'pageNotFound' => true,
])

@section('title', '404 Page not found')

@section('hero')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 d-flex flex-column justify-content-center text-center pt-4 pt-lg-0 order-2 order-lg-1">
                <h1 class="fw-bold text-danger">Oops !!</h1>
                <p>
                    We're sorry, the page you're looking for is not available. If you need medical assistance, please call
                    our 24/7 helpline at <a href="tel:{{ config('app.helpline_number')[0] }}"
                        class="">{{ config('app.helpline_number')[0] }}</a>. Our healthcare
                    experts are ready to assist you in any way they
                    can. Thank you for your patience and understanding.
                </p>
                <div class="">
                    <a href="tel:{{ config('app.helpline_number')[0] }}" class="btn btn-danger btn-rounded"
                        style="border-width: 2px;">
                        <i class="fa-solid fa-phone"></i> {{ config('app.helpline_number')[0] }}
                    </a>
                </div>
            </div>
            <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                <lottie-player src="{{ asset('resources/lottifiles/404.json') }}" background="transparent" speed="1"
                    style="width: 100%; height: auto;" loop autoplay></lottie-player>
            </div>
        </div>
    </div>
@endsection
