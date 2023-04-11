<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

class AdmHospitalCtlr extends Controller
{

    /*
    ------------------------------------------------------------
    Index
    ------------------------------------------------------------
    */

    public function index(Request $request)
    {

        if (($request->get('id') ?? '') != '') {
            if (!Hospital::isHospitalValid($request->get('id'))) {
                if (HttpMethodUtil::isMethodGet()) {
                    return abort(404);
                } else {
                    return JsonUtil::notFound("Invalid hospital");
                }
            }
            return $this->singleHospital($request);
        }

        switch ($request->get('action')) {
            case 'add':
                return $this->addHospital($request);
                break;

            default:
                return $this->getHospitals($request);
                break;
        }
    }

    private function singleHospital(Request $request) {
        switch ($request->get('action')) {
            case 'add':
                break;

            default:
                return $this->getHospitalSingle($request);
                break;
        }
    }

    private function getHospitals(Request $request)
    {
        return view('admin.hospital.hospital')->with([
            'hospitals' => Hospital::getHospitals(),
        ]);
    }

    private function addHospital(Request $request)
    {

        if (HttpMethodUtil::isMethodGet()) {
            return view('admin.hospital.add_hospital')->with([
                'departments' => Master::getDepartmentsAll(),
            ]);
        } else {

            $v = Validator::make($request->all(), [
                'hospital_name' => 'required',
                'phone' => 'numeric:10',
                'username' => [
                    'required',
                    'max:16',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (Hospital::isHospitalAvailableByUsername($value)) {
                            $fail(ucfirst("{$attribute}") . " is not available. Please try different username");
                        }
                    },
                    'regex:/^[a-zA-Z0-9]+$/'
                ],
                'password' => 'required|min:6|max:16',
                'departments' => [
                    'array',
                    function (string $attribute, mixed $value, Closure $fail) {
                        foreach ($value as $d) {
                            if (!Master::isDepartmentIdValid($d)) {
                                $fail("Invalid {$attribute}");
                                break;
                            }
                        }
                    }
                ],
            ], [
                'username.regex' => 'Username can only have alphabets and numbers',
            ]);

            if ($v->fails()) {
                return JsonUtil::getResponse(false, "Validation Error", JsonUtil::$_UNPROCESSABLE_ENTITY, $v->errors());
            }

            DB::beginTransaction();

            try {

                $thumbnail = $request->file('thumbnail');
                $thumbnailName = rand(10000, 99999) . time() . '.' . $thumbnail->getClientOriginalExtension();

                 // store thumbnail in server
                Storage::disk('public')->put('hospital/images/' . $thumbnailName, File::get($thumbnail));

                Hospital::createHospital([
                    'name' => $request->get('hospital_name') ?? '',
                    'is_active' => $request->get('status') ?? 1,
                    'gstin' => $request->get('gstin') ?? '',
                    'contact_person' => $request->get('contact_person') ?? '',
                    'phone' => $request->get('phone') ?? '',
                    'email' => $request->get('email') ?? '',
                    'latitude' => $request->get('latitude') ?? '',
                    'longitude' => $request->get('longitude') ?? '',
                    'address' => $request->get('address') ?? '',
                    'departments' => implode(",", $request->get('departments')),
                    'username' => $request->get('username') ?? '',
                    'password' => password_hash($request->get('name') ?? '', PASSWORD_DEFAULT),
                    'thumbnail' => $thumbnailName,
                ]);

                DB::commit();
                return JsonUtil::getResponse(true, "Hospital has been added successfully", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                DB::rollBack();
                return JsonUtil::serverError();
            }
        }
    }

    private function getHospitalSingle(Request $request)
    {

        if (HttpMethodUtil::isMethodGet()) {
            return view('admin.hospital.hospital_single')->with([
                'data' => Hospital::getHospital($request->get('id')),
                'prev' => Hospital::getPreviousId($request->get('id'))->id ?? null,
                'next' => Hospital::getNextId($request->get('id'))->id ?? null,
            ]);
        }

    }
}
