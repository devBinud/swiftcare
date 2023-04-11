<?php

use App\Http\Controllers\Hospital\HospitalCtlr;
use Illuminate\Support\Facades\Route;

Route::any('/', function () {
    return redirect('hospital/dashboard');
});

Route::any('login', [HospitalCtlr::class, 'login']);

Route::middleware(['hospital'])->group(function () {
    Route::any('dashboard', [HospitalCtlr::class, 'dashboard']);
    Route::any('logout', [HospitalCtlr::class, 'logout']);
    Route::any('bookings', [HospitalCtlr::class, 'bookings']);
});
