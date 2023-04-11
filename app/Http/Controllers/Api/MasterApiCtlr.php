<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Master;
use App\Utils\JsonUtil;
use Illuminate\Http\Request;

class MasterApiCtlr extends Controller
{
    
    public function departments(Request $request)
    {
        if ($request->get('hid') != null) {
            
            $hospital = Hospital::getHospital($request->get('hid'), 'h.departments');
            $hids = $hospital == null ? [] : explode(',', $hospital->departments);
            return JsonUtil::success(Master::getDepartmentsByHospitalIds($hids));
        }
    }

}
