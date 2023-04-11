<?php

namespace App\Http\Middleware;

use App\Models\Module;
use App\Models\Admin;
use App\Models\Booking;
use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Illuminate\Http\Request;

class ModuleAccessMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {

        $productionServer = false;
        $isAdminSubdomain = false;
        $extraIndex = 0;

        $action = $request->get('action');
        $adminId = $request->session()->get('admin_id', null);

        if ($adminId == null) {
            if (HttpMethodUtil::isMethodGet()) {
                return redirect(config('app.url_prefix.admin') . '/login');
            } else {
                return JsonUtil::accessDenied();
            }
        }

        $adminRoles = Admin::getAdmin($adminId) != null ? explode(",", Admin::getAdmin($adminId)->role) : [];

        $uri = $_SERVER['REQUEST_URI'];
        $uri = ltrim($uri, '/');
        $uri = rtrim($uri, '/');
        $uri = explode("?", $uri)[0];
        $uri = explode("/", $uri);

        $minSegment = $productionServer ? 1 : 2; // live server = 1, local server = 2
        
        if (!$isAdminSubdomain) {
            $extraIndex = 1;
            $minSegment += $extraIndex;
        }

        $module = null;

        if (count($uri) > $minSegment) {

            $moduleSlug = $uri[1 + $extraIndex];
            $subModuleSlug = $uri[2 + $extraIndex];

            /*
            ----------------------------------------------------
            |   first check if the module is accessible or not
            ----------------------------------------------------
            */

            $module = Module::getModuleBySlug($moduleSlug);

            if ($module == null) {
                if (HttpMethodUtil::isMethodGet()) {
                    return abort(403);
                } else {
                    return JsonUtil::accessForbidden();
                }
            } else {
                if (count(array_intersect($adminRoles, explode(',', $module->role))) == 0) {
                    if (HttpMethodUtil::isMethodGet()) {
                        return abort(403);
                    } else {
                        return JsonUtil::accessForbidden();
                    }
                }
            }

            /*
            -------------------------------------------------------
            |   Then check if the sub modules are accessible or not
            -------------------------------------------------------
            */

            $subModules = Module::getSubModuleAccessBySlug($moduleSlug, $subModuleSlug);

            $canAccess = false;

            foreach ($subModules as $sm) {
                if (in_array($sm->role_id, $adminRoles)) {
                    switch ($action) {
                        case 'add':
                            if ($sm->create == 1) {
                                $canAccess = true;
                                break 2;
                            }
                            break;
                        case 'edit':
                            if ($sm->update == 1) {
                                $canAccess = true;
                                break 2;
                            }
                            break;
                        case 'delete':
                            if ($sm->delete == 1) {
                                $canAccess = true;
                                break 2;
                            }
                            break;
                        case 'read':
                            if ($sm->read == 1) {
                                $canAccess = true;
                                break 2;
                            }
                            break;
                        default:
                            if ($sm->read == 1) {
                                $canAccess = true;
                                break 2;
                            }
                            break;
                    }
                }
            }

            if (!$canAccess) {
                if (HttpMethodUtil::isMethodGet()) {
                    return abort(403);
                } else {
                    return JsonUtil::accessForbidden();
                }
            }
        } else {
            if (count($uri) == 0 && !$productionServer) {
                $module = Module::getModuleBySlug($uri[0 + $extraIndex]);
            } else if (count($uri) == $minSegment) {
                $module = Module::getModuleBySlug($uri[$minSegment-1]);
            }
        }

        $moduleAccess = [];

        foreach (Module::getModuleAccessAll() as $ma) {
            if (count(array_intersect($adminRoles, explode(",", $ma->role))) > 0) {
                array_push($moduleAccess, $ma->slug);
            }
        }

        // get the url parameters
        $url = basename($_SERVER['REQUEST_URI']);
        $url = preg_replace('/(page=)[^\&]+(\&)*/', "", $url);
        $parsedUrl = parse_url($url);
        $urlParams = $parsedUrl['query'] ?? '';

        $request->merge([
            '_module_access' => $moduleAccess,
            '_admin_roles' => $adminRoles,
            '_module' => $module->slug ?? '',
            '_page_title' => $module != null ? sprintf("%s %s", ucfirst($action), ucfirst($module->slug)) : "Dashboard",
            '_url_params' => $urlParams,
            '_unread_bookings' => Booking::getTotalUnreadBookings(),
        ]);

        return $next($request);
    }
}
