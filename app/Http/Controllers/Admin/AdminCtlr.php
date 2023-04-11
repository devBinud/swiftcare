<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Module;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Illuminate\Http\Request;

class AdminCtlr extends Controller
{
    
    /*
    ------------------------------------------------------------
    Login
    ------------------------------------------------------------
    */

    public function login(Request $request)
    {
        if (HttpMethodUtil::isMethodGet()) {
            return view('admin.login');
        }

        else {

            $admin = Admin::getAdminByPhoneOrEmail($request->get('phone_email') ?? '');

            if ($admin == null) {
                return JsonUtil::getResponse(false, "Invalid credential", JsonUtil::$_UNAUTHORIZED);
            }

            if (!password_verify($request->get('password') ?? '', $admin->password)) {
                return JsonUtil::getResponse(false, "Invalid credential", JsonUtil::$_UNAUTHORIZED);
            }

            $request->session()->put('admin_id', $admin->id);
            $request->session()->put('admin_name', $admin->name);

            return JsonUtil::getResponse(true, "Login successful", JsonUtil::$_STATUS_OK);

        }
    }

    /*
    ------------------------------------------------------------
    Logout
    ------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        $request->session()->forget('admin_name');

        return redirect(config('app.url_prefix.admin') . '/login');
    }

    /*
    ------------------------------------------------------------
    Dashboard
    ------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {

        $moduleAccess = [];

        foreach (Module::getModuleAccessAll() as $ma) {
            if (count(array_intersect($request->get('_admin_roles'), explode(",", $ma->role))) > 0) {
                array_push($moduleAccess, $ma->slug);
            }
        }

        // dd($moduleAccess);

        return view('admin.dashboard');
    }

}
