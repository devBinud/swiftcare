<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Staff;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdmBookingCtlr extends Controller
{

    private $booking;

    public function index(Request $request)
    {

        if ($request->get('save_remark') != null) {
            return $this->remarkBooking($request);
        }

        switch ($request->get('action') ?? '') {
            case '':
                return $this->getBookings($request);
                break;

            default:
                return $this->getBookings($request);
                break;
        }
    }

    private function getBookings(Request $request)
    {

        if ($request->get('id') != null) {
            if ($request->get('assign_staff') != null && HttpMethodUtil::isMethodPost()) {
                return $this->assignStaffToBooking($request);
            }
            return $this->getBookingSingle($request);
        }

        $whereRaw = '1=?';
        $whereParam = [1];

        if ($request->get('search') != '') {
            $whereRaw = '(id = ? OR patient_name LIKE ? OR phone = ? OR email LIKE ?)';
            $whereParam = [
                $request->get('search'),
                "%" . $request->get('search') . "%",
                $request->get('search'),
                "%" . $request->get('search') . "%"
            ];
        }

        if ($request->get('service') != '') {
            $whereRaw .= ' AND service = ?';
            array_push($whereParam, $request->get('service'));
        }

        $data = Booking::getBookings('id, patient_name, phone, address, is_read, service, created_at', $whereRaw, $whereParam);

        return view('admin.bookings.bookings')->with([
            'bookings' => $data,
        ]);
    }

    private function getBookingSingle(Request $request)
    {

        $data = Booking::getBookingSingle($request->get('id'));
        $v = view('admin.bookings.booking_single', [
            'data' => $data,
            'hospital' => $data->service == 'Hospital' ? Booking::getHospitalBookingSingle($data->id) : null,
            'remarks' => Booking::getBookingRemarks($data->id),
            'drivers' => $data->service == 'Ambulance' ? Staff::getStaffByRole('Driver') : null,
            'assignedStaff' => explode(",", Booking::getBookingAssignedStaff($data->id) == null ? "" :
                Booking::getBookingAssignedStaff($data->id)->staff_ids),
            'doctorBooking' => $data->service == 'Doctor' ? Booking::getDoctorBooking($data->id) : null,
        ])->render();

        if ($data->is_read == 0) {
            Booking::updateBooking($request->get('id'), [
                'is_read' => 1,
                'read_at' => date('Y-m-d H:i:s'),
                'read_by' => $request->session()->get('admin_id', null),
            ]);
        }

        return JsonUtil::getResponse(true, "", JsonUtil::$_STATUS_OK, $v);
    }

    private function remarkBooking(Request $request)
    {

        $v = Validator::make($request->all(), [
            'remark' => 'required|max:150',
            'booking_id' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Booking::isBookingIdValid($value)) {
                        $fail(ucfirst("{$attribute}") . " is not valid");
                    }
                },
            ]
        ]);

        if ($v->fails()) {
            return JsonUtil::validationError($v->errors());
        }

        try {
            Booking::createBookingRemark([
                'booking_id' => $request->get('booking_id'),
                'remark' => $request->get('remark'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $request->session()->get('admin_id', null)
            ]);

            return JsonUtil::success(null, "Remarked successfullt");
        } catch (Exception $e) {
            return JsonUtil::serverError();
        }
    }

    private function assignStaffToBooking(Request $request)
    {

        $this->booking = Booking::getBookingSingle($request->get('id'));

        $checkForRoles = [];

        switch ($this->booking->service) {
            case 'Ambulance':
                $checkForRoles = ['Driver'];
                break;
            case 'Home Healthcare':
                $checkForRoles = ['Home Healthcare'];
                break;
        }

        $v = Validator::make($request->all(), [
            'id' => function (string $attribute, mixed $value, Closure $fail) {
                if ($this->booking == null) {
                    $fail("Booking ID is not valid");
                }
            },
            'staff' => [
                'required',
                'array',
                function (string $attribute, mixed $value, Closure $fail) {

                    $checkForRoles = [];

                    switch ($this->booking->service) {
                        case 'Ambulance':
                            $checkForRoles = ['Driver'];
                            break;
                        case 'Home Healthcare':
                            $checkForRoles = ['Home Healthcare'];
                            break;
                    }

                    foreach ($value as $id) {
                        if (!Staff::isRoleAssignedToStaff($id, $checkForRoles)) {
                            $fail("Unauthorized staff member");
                            break;
                        }
                    }
                }
            ]

        ]);

        if ($v->fails()) {
            return JsonUtil::validationError($v->errors());
        }

        try {
            Booking::updateBookingStaffAssign($request->get('id'), [
                'staff_ids' => strval(implode(",", $request->get('staff'))),
                'created_by' => $request->session()->get('admin_id', null),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_by' => $request->session()->get('admin_id', null),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return JsonUtil::success(null, "Staff members have been assigned successfully");
        } catch (Exception $e) {
            return JsonUtil::serverError();
        }
    }
}
