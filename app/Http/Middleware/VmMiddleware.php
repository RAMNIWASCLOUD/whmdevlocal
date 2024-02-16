<?php

namespace App\Http\Middleware;

use Closure;

class VmMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $role = \Session::get('role');
        if(empty($role) && $role!='3') 
        {
           return redirect('login');
        } 
        
        return $next($request);
    }
}
