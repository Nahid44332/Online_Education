<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
  protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        // যদি স্টুডেন্ট রাউটে ঢোকার চেষ্টা করে, তবে স্টুডেন্ট লগইনে পাঠাবে
        if ($request->is('student') || $request->is('student/*')) {
            return route('student.login');
        }
        
        // অন্য সব ক্ষেত্রে এডমিন লগইনে পাঠাবে
        return route('login');
    }
}
}
