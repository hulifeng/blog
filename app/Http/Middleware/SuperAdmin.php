<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SuperAdmin
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
        if (Auth::id() != 1) {
            return redirect('/')->with('message', '您不是超级管理员，不能登录后台！');
        }
        return $next($request);
    }
}
