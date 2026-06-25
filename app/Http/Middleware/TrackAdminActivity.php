<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackAdminActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $admin->update(['last_activity' => now()]);
        }

        return $next($request);
    }
}
