<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Hospital;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class HospitalCtlr extends Controller
{

    /*
    ------------------------------------------------------------
    Login
    ------------------------------------------------------------
    */

    public function login(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            return view('hospital.login');
        }

        $hospital = Hospital::getHospitalByUsername($request->get('username') ?? '');

        if ($hospital == null) {
            return JsonUtil::accessDenied("Invalid username or password");
        }

        if (!password_verify($request->get('password'), $hospital->password)) {
            return JsonUtil::accessDenied("Invalid username or password");
        }

        $request->session()->put('hospital_id', $hospital->id);
        return JsonUtil::getResponse(true, "Login successful", JsonUtil::$_STATUS_OK);
    }

    /*
    ------------------------------------------------------------
    Logout
    ------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $request->session()->forget('hospital_id');
        return redirect('hospital/login');
    }

    /*
    ------------------------------------------------------------
    Dashboard
    ------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            return view('hospital.dashboard');
        }
    }

    /*
    ------------------------------------------------------------
    Bookings
    ------------------------------------------------------------
    */

    public function bookings(Request $request)
    {

        // update status
        switch ($request->get('action')) {
            case 'update-status':
                return $this->updateStatus($request);
                break;

            default:

                break;
        }

        // get signle booking
        if ($request->get('id') ?? '' != '') {
            return $this->getBookingSingle($request);
        }

        // all bookings
        $whereRaw = 'b.service = ? AND h.hospital_id = ?';
        $whereParam = ['Hospital', Session::get('hospital_id')];

        if ($request->get('search') != '') {
            $whereRaw .= ' AND (b.id = ? OR b.patient_name LIKE ? OR b.phone = ? OR b.email LIKE ?)';
            array_push($whereParam, $request->get('search'));
            array_push($whereParam, "%" . $request->get('search') . "%");
            array_push($whereParam, $request->get('search'));
            array_push($whereParam, "%" . $request->get('search') . "%");
        }

        if ($request->get('status') != '') {
            $whereRaw .= ' AND h.status = ?';
            array_push($whereParam, $request->get('status'));
        }

        $data = Booking::getBookingsForHospital('b.id, b.patient_name, b.phone, b.address, b.is_read, b.service, b.created_at, h.status', $whereRaw, $whereParam);
        return view('hospital.bookings')->with([
            'bookings' => $data,
        ]);
    }

    private function getBookingSingle(Request $request)
    {

        $data = Booking::getBookingSingle($request->get('id'));
        $v = view('hospital.booking_single', [
            'data' => $data,
            'hospital' => Booking::getHospitalBookingSingle($data->id),
        ])->render();

        return JsonUtil::getResponse(true, "", JsonUtil::$_STATUS_OK, $v);
    }

    private function updateStatus(Request $request)
    {
        $ids = $request->get('ids') ?? [];
        $status = $request->get('status') ?? '';

        if (count($ids) != Booking::countHospitalBookingByStatus('Pending', $ids)) {
            return JsonUtil::unprocessableEntity("Status of pending bookings can only be changed");
        }

        try {
            Booking::updateHospitalBookingMultiple($ids, ['status' => $status, 'status_updated_at' => date('Y-m-d H:i:s')]);
            return JsonUtil::success(null, "Changes have been made successfully");
        } catch (Exception $e) {
            return JsonUtil::serverError();
        }
    }
}
