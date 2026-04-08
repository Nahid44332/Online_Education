<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubadminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next, $role)
{
    // ১. চেক করবে ইউজার subadmin গার্ডে লগইন করা কি না
    if (!Auth::guard('subadmin')->check()) {
        return redirect()->route('subadmin.login')->with('error', 'Please login first');
    }

    // ২. চেক করবে ইউজারের পজিশন আর রাউটের রিকোয়ার্ড রোল এক কি না
    if (Auth::guard('subadmin')->user()->position !== $role) {
        return abort(403, 'Unauthorized action.'); // ভুল রোলে ঢুকলে ৪MD৩ এরর দিবে
    }

    return $next($request);
}
}
