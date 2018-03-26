<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckToken
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
        $theToken = $request->session()->get('_token');

        if(Redis::exists($theToken))
        {
            return $next($request);
        }
        else
        {
            return redirect('/');
        }
    }
  
}
