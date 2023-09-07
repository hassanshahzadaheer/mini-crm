<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
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

if (!Auth::check()) {
    // If the user is not authenticated, redirect them to the login page or return an error response
    return redirect('/login');
}

$user = Auth::user();



$user = Auth::user();

// Check if the user has the specified role
if ($user->role === 'admin') {
    return $next($request);
}



// If the user does not have the required role, redirect or return an error response
return redirect('/unauthorized'); // You can customize this URL or response as needed

    }
}
