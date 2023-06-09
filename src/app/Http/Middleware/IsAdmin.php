<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        if (Auth::user() &&  Auth::user()->role == Role::ADMIN->value) {
            return $next($request);
        }

        if(Auth::user()->role==Role::PARENT->value){
            $route = route('parent_dashboard');
        }elseif(Auth::user()->role==Role::SCHOOL->value){
            $route = route('school_dashboard');
        }
        return redirect($route)->with('error_status','You do not have admin access');
    }
}
