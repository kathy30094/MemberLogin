<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckIsPlayer
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
        $theSession = json_decode(Redis::get($request->session()->get('_token')),true);
        if($theSession['Status'] == '1')
        {
            return $next($request);
        }
        else
        {
            return redirect('/');
        }
    }
  
}
