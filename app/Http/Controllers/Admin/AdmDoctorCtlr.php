<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Master;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdmDoctorCtlr extends Controller
{

    public function index(Request $request)
    {

        if (($request->get('id') ?? '') != '') {
            if (!Doctor::isDoctorValid($request->get('id'))) {
                return JsonUtil::notFound("Invalid doctor");
            }

            if ($request->get('clinic') == 1) {
                return $this->getDoctorClinics($request);
            } else if ($request->get('clinic') == 2) {
                return $this->getClinicsForDoctor($request);
            } else if ($request->get('action') == 'edit-clinic') {
                return $this->editClinic($request);
            } else {
                return $this->singleDoctor($request);
            }
        }


        switch ($request->get('action')) {
            case 'add':
                return $this->addDoctor($request);
                break;
            case 'edit-clinic':
                return $this->editClinic($request);
                break;
            default:
                return $this->getDoctors($request);
                break;
        }
    }

    private function singleDoctor(Request $request)
    {

        if (HttpMethodUtil::isMethodPost()) {
            return $this->editDoctor($request);
        }

        $data = Doctor::getDoctorSingle($request->get('id'));

        $view = view('admin.doctor.partial.doctor_single', [
            'data' => $data,
            'specialities' => Master::getSpecialities(),
        ])->render();

        return JsonUtil::success($view);
    }

    private function getDoctors(Request $request)
    {
        return view('admin.doctor.doctors')->with([
            'doctors' => Doctor::getDoctors('d.id, d.name, d.gender, d.speciality_ids, d.qualification, d.image, d.is_active,
                GROUP_CONCAT(DISTINCT s.name separator ", ") as specialities, d.clinic_ids'),
            'specialities' => Master::getSpecialities(),
        ]);
    }

    private function addDoctor(Request $request)
    {

        if (!HttpMethodUtil::isMethodPost()) {
            return JsonUtil::methodNotAllowed();
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|regex:/^((?!Dr(\.?\s+)).*)$/',
            'phone' => 'nullable|numeric:10',
            'email' => 'nullable|email|max:100',
            'gender' => 'in:Male,Female,Other',
            'qualification' => 'nullable|max:100',
            'experience' => 'nullable|numeric|max:1000',
            'address' => 'nullable|max:100',
            'specialities' => [
                'required',
                'array',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value == null || count($value) == 0 || !Master::isSpecialitiesValid($value)) {
                        $fail("Invalid specialities");
                    }
                }
            ],
            'doctor_image' => 'nullable|mimes:jpeg,jpg,png|max:2000',

        ], [
            'name.regex' => "Do not use Dr. in the name field",
        ]);

        if ($validator->fails()) {
            return JsonUtil::validationError($validator->errors());
        }

        $doctorImage = $request->file('doctor_image');
        $doctorImageName = $doctorImage != null ? rand(10000, 99999) . time() . '.' . $doctorImage->getClientOriginalExtension() : null;

        try {

            if ($doctorImage != null) {
                Storage::disk('public')->put('doctor/images/' . $doctorImageName, File::get($doctorImage));
            }

            Doctor::addDoctor([
                'name' => $request->get('name'),
                'speciality_ids' => implode(',', $request->get('specialities')),
                'gender' => $request->get('gender'),
                'experience_from' => $request->get('experience') == null ? null :
                    date('Y', strtotime('-' . $request->get('experience') . ' year')),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
                'qualification' => $request->get('qualification'),
                'image' => $doctorImageName,
                'address' => $request->get('address'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $request->session()->get('admin_id'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $request->session()->get('admin_id'),
            ]);

            return JsonUtil::success(null, "Doctor has been added successfully");
        } catch (Exception $e) {
            File::delete('storage/app/public/doctor/images/' . $doctorImageName);
            return JsonUtil::serverError();
        }
    }

    private function editDoctor(Request $request)
    {
        if (!HttpMethodUtil::isMethodPost()) {
            return JsonUtil::methodNotAllowed();
        }

        if (!Doctor::isDoctorValid($request->get('id'))) {
            return JsonUtil::getResponse(false, "Invalid doctor", JsonUtil::$_UNPROCESSABLE_ENTITY);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100|regex:/^((?!Dr(\.?\s+)).*)$/',
            'phone' => 'nullable|numeric:10',
            'email' => 'nullable|email|max:100',
            'gender' => 'in:Male,Female,Other',
            'qualification' => 'nullable|max:100',
            'experience' => 'nullable|numeric|max:1000',
            'address' => 'nullable|max:100',
            'specialities' => [
                'required',
                'array',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value == null || count($value) == 0 || !Master::isSpecialitiesValid($value)) {
                        $fail("Invalid specialities");
                    }
                }
            ],
            'doctor_image' => 'nullable|mimes:jpeg,jpg,png|max:2000',

        ], [
            'name.regex' => "Do not use Dr. in the name field",
        ]);

        if ($validator->fails()) {
            return JsonUtil::validationError($validator->errors());
        }

        try {

            $values = [
                'name' => $request->get('name'),
                'speciality_ids' => implode(',', $request->get('specialities')),
                'gender' => $request->get('gender'),
                'experience_from' => $request->get('experience') == null ? null :
                    date('Y', strtotime('-' . $request->get('experience') . ' year')),
                'phone' => $request->get('phone'),
                'email' => $request->get('email'),
                'qualification' => $request->get('qualification'),
                'address' => $request->get('address'),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $request->session()->get('admin_id'),
            ];

            if ($request->file('doctor_image') != null) {

                $doctorImage = $request->file('doctor_image');
                $doctorImageName = rand(10000, 99999) . time() . '.' . $doctorImage->getClientOriginalExtension();

                $prevImage = Doctor::getDoctorSingle($request->get('id'))->image;
                File::delete('storage/app/public/doctor/images/' . $prevImage);
                Storage::disk('public')->put('doctor/images/' . $doctorImageName, File::get($doctorImage));

                $values['image'] = $doctorImageName;
            }

            Doctor::editDoctor($request->get('id'), $values);

            return JsonUtil::getResponse(true, "Doctor has been saved successfully", JsonUtil::$_STATUS_OK);
        } catch (Exception $e) {
            File::delete('storage/app/public/doctor/images/' . $doctorImageName);
            return JsonUtil::serverError();
        }
    }

    private function getDoctorClinics(Request $request)
    {

        $doctorId = $request->get('id');

        if ($request->get('view_schedule') == 1) {

            $clinicId = $request->get('clinic_id');

            if (HttpMethodUtil::isMethodGet()) {
                return view('admin.doctor.clinic_schedule', [
                    'weekdays' => Master::getWeekDays(),
                    'schedule' => Doctor::getDoctorClinicTime($doctorId, $clinicId)[0],
                    'clinic' => Clinic::getClinic($clinicId),
                    'doctor' => Doctor::getDoctorSingle($doctorId),
                ]);
            }

            // dd($request->all());

            $scheduleIds = $request->get('schedule_id') ?? [];
            $weekDayIds = $request->get('week_day_id') ?? [];
            $timeFrom = $request->get('time_from') ?? [];
            $timeTo = $request->get('time_to') ?? [];

            $valuesToInsert = [];

            for ($i = 0; $i < count($scheduleIds); $i++) {
                // if schedule id is not null then update it
                if ($scheduleIds[$i] != null) {
                    if (!isset($weekDayIds) || !isset($timeFrom) || !isset($timeTo)) {
                        return JsonUtil::getResponse(false, "Invalid time slot selected", JsonUtil::$_UNPROCESSABLE_ENTITY);
                    }

                    try {
                        Doctor::updateDoctorClinicTime($scheduleIds[$i], [
                            'doctor_id' => $doctorId,
                            'clinic_id' => $clinicId,
                            'week_day_id' => $weekDayIds[$i],
                            'time_from' => $timeFrom[$i],
                            'time_to' => $timeTo[$i],
                        ]);
                    } catch (Exception $e) {
                        return JsonUtil::serverError();
                    }
                }
                // else insert it
                else {
                    array_push($valuesToInsert, [
                        'doctor_id' => $doctorId,
                        'clinic_id' => $clinicId,
                        'week_day_id' => $weekDayIds[$i],
                        'time_from' => $timeFrom[$i],
                        'time_to' => $timeTo[$i],
                    ]);
                }
            }

            // dd($valuesToInsert);

            try {
                Doctor::addDoctorClinicTime($valuesToInsert);
            } catch (Exception $e) {
                return JsonUtil::serverError();
            }

            return JsonUtil::success(null, "Clinic schedules have been saved successfully");
        }

        $clinicIds = Doctor::getDoctorSingle($doctorId, 'd.clinic_ids')->clinic_ids;
        $docClinics = Clinic::getClinicsByIds(explode(',', $clinicIds));

        $view = view('admin.doctor.partial.doctor_clinic', [
            'docClinics' => $docClinics,
            'doctorId' => $request->get('id'),
        ])->render();
        return JsonUtil::success($view);
    }

    private function getClinicsForDoctor(Request $request)
    {
        $selectedClinic = $request->get('selected_clinic') ?? '';

        if ($selectedClinic != '') {
            $clinic = Clinic::getClinic($selectedClinic);

            return JsonUtil::success(view('admin.doctor.partial.selected_clinics', [
                'clinic' => $clinic,
                'weekdays' => Master::getWeekDays(),
                'doctorId' => $request->get('id'),
            ])->render());
        }

        $search = $request->get('search') ?? '';
        $clinics = Clinic::getClinics(null, 'c.name LIKE ?', ["%$search%"]);

        $view = view('admin.doctor.partial.get_search_clinics', [
            'clinics' => $clinics,
            'doctorId' => $request->get('id'),
        ])->render();
        return JsonUtil::success($view);
    }

    private function editClinic(Request $request)
    {

        $clinicIds = $request->get('doc_clinics') ?? [];

        if (!is_array($clinicIds) || !Clinic::isClinicIdsValid($clinicIds)) {
            return JsonUtil::getResponse(false, "Invalid clinic selected", JsonUtil::$_UNAUTHORIZED);
        }

        try {
            Doctor::editDoctor($request->get('id'), ['clinic_ids' => implode(',', $clinicIds)]);
            return JsonUtil::success(null, "Clinics have been successfully assigned to the doctor");
        } catch (Exception $e) {
            return JsonUtil::serverError($e->getMessage());
        }
    }
}
