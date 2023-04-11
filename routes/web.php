<?php

use App\Http\Controllers\Admin\AdmBookingCtlr;
use App\Http\Controllers\Admin\AdmClinicCtlr;
use App\Http\Controllers\Admin\AdmDoctorCtlr;
use App\Http\Controllers\Admin\AdmHospitalCtlr;
use App\Http\Controllers\Admin\AdminCtlr;
use App\Http\Controllers\BookingCtlr;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::group(['domain' => '{subdomain}.localhost'], function () {
//     Route::get('/', function ($subdomain) {
//         return $subdomain;
//     });
// });

Route::prefix('admin')->group(function ()
{
    Route::any('login', [AdminCtlr::class, 'login']);

    Route::middleware(['module.access'])->group(function () {

        Route::any('logout', [AdminCtlr::class, 'logout']);
        Route::any('/', [AdminCtlr::class, 'dashboard']);

        Route::any('hospital', [AdmHospitalCtlr::class, 'index']);
        Route::any('clinic', [AdmClinicCtlr::class, 'index']);
        Route::any('doctor', [AdmDoctorCtlr::class, 'index']);
        Route::any('bookings', [AdmBookingCtlr::class, 'index']);

    });
});


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::view('/', 'public.home');
Route::view('/contact', 'public.contact');
Route::any('book/{item}', [BookingCtlr::class, 'index']);
