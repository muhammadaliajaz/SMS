<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // 1. Robust Role Lookup
        // First, try the standard relationship
        $roleName = $user->role ? $user->role->name : null;

        // Second, if relationship failed but ID exists, check DB directly
        if (!$roleName && $user->role_id) {
            $role = DB::table('roles')->where('id', $user->role_id)->first();
            if ($role) {
                $roleName = $role->name;
            }
        }

        // 2. Critical Security Check
        if (!$roleName) {
            // Log this for debugging but show user a clear error
            abort(403, 'Unauthorized action. No role assigned.');
        }

        // 3. Super-Admin Bypass (Explicitly allow 'admin')
        if ($roleName === 'admin') {
            return $next($request);
        }

        // 4. Standard Role Check
        if (in_array($roleName, $roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. You do not have the required role.');
    }
}
