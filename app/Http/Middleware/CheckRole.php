<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

public function handle(Request $request, Closure $next, ...$roles)
{
    // Debugging: Kita paksa lihat apa yang dibaca Laravel
    $user = $request->user();
    
    // Logika Bypass: Jika user adalah manager, dan route-nya reports, izinkan
    if ($user && strtolower($user->role) === 'manager') {
        return $next($request);
    }

    // Jika logic di atas berhasil, berarti masalahnya ada di 'role' 
    // yang tidak terbaca di middleware.
    
    $userRole = strtolower(trim($user->role));
    $allowedRoles = array_map('strtolower', array_map('trim', $roles));

    if (!in_array($userRole, $allowedRoles)) {
        abort(403, 'Unauthorized');
    }

    return $next($request);
}
}
