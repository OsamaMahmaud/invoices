<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;

use Closure;

class CheckCredentialsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if('email'== $request->email && 'password' == $request->password && 'status' == 'مفعل')
       {
        return $next($request);
       }
       else
       {
        return response()->json(['message' => 'Unauthorized'], 401);
       }
    }
}
