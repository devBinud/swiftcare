<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
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

class AdmClinicCtlr extends Controller
{
    
    public function index(Request $request)
    {

        if (($request->get('id') ?? '') != '') {
            if (!Clinic::isClinicValid($request->get('id'))) {
                if (HttpMethodUtil::isMethodGet()) {
                    return abort(404);
                } else {
                    return JsonUtil::notFound("Invalid clinic");
                }
            }
            return $this->singleClinic($request);
        }

        switch ($request->get('action')) {
            case 'add':
                return $this->addClinic($request);
                break;

            default:
                return $this->getClinics($request);
                break;
        }
    }

    private function singleClinic(Request $request) {
        switch ($request->get('action')) {
            case 'add':
                break;

            default:
                return $this->getClinicSingle($request);
                break;
        }
    }

    private function getClinics(Request $request)
    {
        return view('admin.clinic.clinic')->with([
            'clinics' => Clinic::getClinics(),
        ]);
    }

    private function addClinic(Request $request)
    {

        if (HttpMethodUtil::isMethodGet()) {
            return view('admin.clinic.add_clinic')->with([
            ]);
        } else {

            $v = Validator::make($request->all(), [
                'clinic_name' => 'required',
                'phone' => 'numeric:10',
                'username' => [
                    'required',
                    'max:16',
                    function (string $attribute, mixed $value, Closure $fail) {
                        if (Clinic::isClinicAvailableByUsername($value)) {
                            $fail(ucfirst("{$attribute}") . " is not available. Please try different username");
                        }
                    },
                    'regex:/^[a-zA-Z0-9]+$/'
                ],
                'password' => 'required|min:6|max:16',
            ], [
                'username.regex' => 'Username can only have alphabets and numbers',
            ]);

            if ($v->fails()) {
                return JsonUtil::getResponse(false, "Validation Error", JsonUtil::$_UNPROCESSABLE_ENTITY, $v->errors());
            }

            DB::beginTransaction();

            $thumbnail = $request->file('thumbnail');
            $thumbnailName = rand(10000, 99999) . time() . '.' . $thumbnail->getClientOriginalExtension();

            try {

                 // store thumbnail in server
                Storage::disk('public')->put('clinic/images/' . $thumbnailName, File::get($thumbnail));

                Clinic::createClinic([
                    'name' => $request->get('clinic_name') ?? '',
                    'is_active' => $request->get('status') ?? 1,
                    'gstin' => $request->get('gstin') ?? '',
                    'contact_person' => $request->get('contact_person') ?? '',
                    'phone' => $request->get('phone') ?? '',
                    'email' => $request->get('email') ?? '',
                    'latitude' => $request->get('latitude') ?? '',
                    'longitude' => $request->get('longitude') ?? '',
                    'address' => $request->get('address') ?? '',
                    'username' => $request->get('username') ?? '',
                    'password' => password_hash($request->get('name') ?? '', PASSWORD_DEFAULT),
                    'thumbnail' => $thumbnailName,
                ]);

                DB::commit();
                return JsonUtil::getResponse(true, "Clinic has been added successfully", JsonUtil::$_STATUS_OK);
            } catch (Exception $e) {
                DB::rollBack();
                File::delete('storage/app/public/clinic/images/' . $thumbnailName);
                return JsonUtil::serverError();
            }
        }
    }

    private function getClinicSingle(Request $request)
    {

        if (HttpMethodUtil::isMethodGet()) {
            return view('admin.clinic.clinic_single')->with([
                'data' => Clinic::getClinic($request->get('id')),
                'prev' => Clinic::getPreviousId($request->get('id'))->id ?? null,
                'next' => Clinic::getNextId($request->get('id'))->id ?? null,
            ]);
        }

    }

}
