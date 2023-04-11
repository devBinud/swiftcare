<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Hospital;
use App\Models\Master;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookingCtlr extends Controller
{

    public function index(Request $request, $item)
    {
        switch ($item) {
            case 'ambulance':
                return $this->bookAmbulance($request);
                break;
            case 'hospital':
                return $this->bookHospital($request);
                break;
            case 'lab-test':
                return $this->bookLabTest($request);
                break;
            case 'home-healthcare':
                return $this->bookHomeHealthcare($request);
                break;
            case 'doctor':
                return $this->bookDoctor($request);
                break;
            default:

                break;
        }
    }

    private function bookAmbulance(Request $request)
    {

        if (HttpMethodUtil::isMethodGet()) {
            return view('public.book_ambulance')->with([
                'hospitals' => Hospital::getHospitals('id, name, address', 0),
            ]);
        }

        $v = Validator::make($request->all(), [
            'patient_name' => 'required',
            'phone' => 'required|digits:10',
            'address' => 'required|max:150',
            'hospital' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value != '' && !Hospital::isHospitalValid($value)) {
                        $fail(ucfirst("{$attribute}") . " is not valid");
                    }
                }
            ]
        ]);

        if ($v->fails()) {
            return JsonUtil::validationError($v->errors());
        }

        DB::beginTransaction();

        try {

            Booking::createBooking([
                'patient_name' => $request->get('patient_name'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'service' => 'Ambulance',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();

            return JsonUtil::getResponse(true, "Ambulance has been booked successfully", JsonUtil::$_STATUS_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return JsonUtil::serverError();
        }
    }

    private function bookHospital(Request $request)
    {

        if (HttpMethodUtil::isMethodGet()) {
            return view('public.book_hospital', [
                'hospitals' => Hospital::getHospitals('id, name, address', 0),
            ]);
        }

        $v = Validator::make($request->all(), [
            'patient_name' => 'required',
            'phone' => 'required|digits:10',
            'age' => 'required|numeric|max:120',
            'address' => 'required|max:150',
            'hospital' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Hospital::isHospitalValid($value)) {
                        $fail(ucfirst("{$attribute}") . " is not valid");
                    }
                }
            ],
            'department' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value != '' && !Master::isDepartmentIdValid($value)) {
                        $fail(ucfirst("{$attribute}") . " is not valid");
                    }
                }
            ],
            'date' => 'required|date|after_or_equal:today',
            'time_from' => 'nullable|date_format:H:i',
            'time_to' => 'nullable|date_format:H:i|after:time_from',
        ]);

        if ($v->fails()) {
            return JsonUtil::validationError($v->errors());
        }

        DB::beginTransaction();

        try {

            $bookingId = Booking::createBooking([
                'patient_name' => $request->get('patient_name'),
                'phone' => $request->get('phone'),
                'age' => $request->get('age'),
                'address' => $request->get('address'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'service' => 'Hospital',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            Booking::updateHospitalBooking($bookingId, [
                'hospital_id' => $request->get('hospital') ?? null,
                'department_id' => $request->get('department') ?? null,
                'date' => $request->get('date'),
                'time_from' => $request->get('time_from') ?? null,
                'time_to' => $request->get('time_to') ?? null,
            ]);

            DB::commit();

            return JsonUtil::getResponse(true, "Hospital has been booked successfully", JsonUtil::$_STATUS_OK);
        } catch (Exception $e) {
            DB::rollBack();
            return JsonUtil::serverError();
        }
    }

    private function bookLabTest(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            return view('public.lab_test');
        }

        $v = Validator::make($request->all(), [
            'patient_name' => 'required',
            'phone' => 'required|digits:10',
            'age' => 'required|numeric|max:120',
            'address' => 'required|max:150',
            'prescription' => 'required|mimes:pdf,jpeg,jpg,png|max:2000',
        ]);

        if ($v->fails()) {
            return JsonUtil::validationError($v->errors());
        }

        $prescription = $request->file('prescription');
        $prescriptionName = rand(10000, 99999) . time() . '.' . $prescription->getClientOriginalExtension();

        DB::beginTransaction();

        try {

            Storage::disk('public')->put('bookings/prescriptions/' . $prescriptionName, File::get($prescription));

            $bookingId = Booking::createBooking([
                'patient_name' => $request->get('patient_name'),
                'phone' => $request->get('phone'),
                'age' => $request->get('age'),
                'address' => $request->get('address'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'prescription' => $prescriptionName,
                'service' => 'Lab Test',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            DB::commit();

            $view = view('public.partial.booking_success', [
                'referenceId' => 'LT' . date('y') . str_pad($bookingId, 5, 0, STR_PAD_LEFT),
                'service' => 'lab test',
            ])->render();

            return JsonUtil::success($view);
        } catch (Exception $e) {
            DB::rollBack();
            File::delete('storage/app/public/bookings/prescriptions/' . $prescriptionName);
            return JsonUtil::serverError();
        }
    }

    private function bookDoctor(Request $request)
    {

        switch ($request->get('view')) {
            case 'clinic':
                return $this->getClinicsForDoctor($request);
                break;
            case 'clinic-time':
                return $this->getClinicTimeForDoctor($request);
                break;

            default:

                break;
        }

        if ($request->get('sid') ?? '' != '') {
            return $this->getDoctorsForSpeciality($request->get('sid'));
        }

        if (HttpMethodUtil::isMethodGet()) {
            return view('public.book_doctor', [
                'specialities' => Master::getSpecialitiesInUse(),
            ]);
        }

        $validator = Validator::make($request->all(), [
            'doctor' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Doctor::isDoctorValid($value)) {
                        $fail("Please select a doctor");
                    }
                }
            ],
            'clinic' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Clinic::isClinicValid($value)) {
                        $fail("Please select a clinic");
                    }
                }
            ],
            'time_slot' => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!Doctor::isDoctorClinicTimeValid($value)) {
                        $fail("Please select a time slot");
                    }
                }
            ],
            'patient_name' => 'required|max:100',
            'phone' => 'required|digits:10',
            'age' => 'required|numeric|max:120',
            'address' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return JsonUtil::validationError($validator->errors());
        }

        // return JsonUtil::getResponse(false, "", 500, $clinicTime = Doctor::getDoctorClinicTimeSingle($request->get('time_slot'), 'w.week_day, ct.time_from, ct.time_to'));

        DB::beginTransaction();
        try {

            $bookingId = Booking::createBooking([
                'patient_name' => $request->get('patient_name'),
                'phone' => $request->get('phone'),
                'age' => $request->get('age'),
                'address' => $request->get('address'),
                'latitude' => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'service' => "Doctor",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $clinicTime = Doctor::getDoctorClinicTimeSingle($request->get('time_slot'), 'w.week_day, ct.time_from, ct.time_to');
            $bookingDate = null;

            if ($clinicTime->week_day >= date('w')) {
                $bookingDate = date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . ($clinicTime->week_day - date('w')) . ' days'));
            } else {
                $bookingDate = date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . (6 - date('w') + $clinicTime->week_day + 1) . ' days'));
            }

            Booking::createBookingDoctor([
                'booking_id' => $bookingId,
                'doctor_id' => $request->get('doctor'),
                'clinic_id' => $request->get('clinic'),
                'booking_date' => $bookingDate,
                'time_from' => date('H:i:s', strtotime($clinicTime->time_from)),
                'time_to' => date('H:i:s', strtotime($clinicTime->time_to)),
            ]);

            DB::commit();

            $view = view('public.partial.booking_success', [
                'referenceId' => date('y') . str_pad($bookingId, 5, 0, STR_PAD_LEFT),
                'service' => 'doctor',
            ])->render();

            return JsonUtil::success($view);
        } catch (Exception $e) {
            DB::rollBack();
            return JsonUtil::serverError($e->getMessage());
        }
    }

    private function getDoctorsForSpeciality($sid)
    {

        $whereRaw = "FIND_IN_SET(?, d.speciality_ids) AND d.is_active = 1";
        $whereParam = [$sid];

        $view = view('public.partial.doctors_for_speciality', [
            'doctors' => Doctor::getDoctors('d.id, d.name, d.gender, d.qualification, d.image,
                GROUP_CONCAT(DISTINCT s.name separator ", ") as specialities', $whereRaw, $whereParam)
        ])->render();

        return JsonUtil::success($view);
    }

    private function getClinicsForDoctor(Request $request)
    {
        $docID = $request->get('doctor_id') ?? '';
        $clinics = Clinic::getClinicsForDoctor($docID);

        $view = view('public.partial.clinics_for_doctor', [
            'clinics' => $clinics,
        ])->render();

        return JsonUtil::success($view);
    }

    private function getClinicTimeForDoctor(Request $request)
    {

        $doctorId = $request->get('doctor_id') ?? '';
        $clinicId = $request->get('clinic_id') ?? '';

        return JsonUtil::success(view('public.partial.doctor_clinic_time', [
            'schedule' => Doctor::getDoctorClinicTime($doctorId, $clinicId)[0],
            'weekdays' => Master::getWeekDays(),
        ])->render());
    }

    private function bookHomeHealthcare(Request $request) {

        if (HttpMethodUtil::isMethodGet()) {
            return view('public.book_home_healthcare');
        }

        $validator = Validator::make($request->all(), [
            'patient_name' => 'required|max:100',
            'phone' => 'required|digits:10',
            'age' => 'required|numeric|max:120',
            'health_issue' => 'required|max:150',
            'address' => 'required|max:150',
        ]);

        if ($validator->fails()) {
            return JsonUtil::validationError($validator->errors());
        }

        try {
            $bookingId = Booking::createBooking([
                'patient_name' => $request->get('patient_name'),
                'phone' => $request->get('phone'),
                'age' => $request->get('age'),
                'address' => $request->get('address'),
                'health_issue' => $request->get('health_issue'),
                'latitude' => $request->get('latitude') ?? null,
                'longitude' => $request->get('longitude') ?? null,
                'service' => 'Home Healthcare',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            $view = view('public.partial.booking_success', [
                'referenceId' => date('y') . str_pad($bookingId, 5, 0, STR_PAD_LEFT),
                'service' => 'lab test',
            ])->render();

            return JsonUtil::success($view);
        } catch (Exception $e) {
            return JsonUtil::serverError();
        }

    }
}
