<?php

namespace App\Http\Middleware;

use App\Utils\HttpMethodUtil;
use App\Utils\JsonUtil;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HospitalMW
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->session()->get('hospital_id', null) == null) {
            if (HttpMethodUtil::isMethodGet()) {
                return redirect('hospital/login');
            } else {
                return JsonUtil::accessDenied();
            }
        }

        return $next($request);
    }
}
