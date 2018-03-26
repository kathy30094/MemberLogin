<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class CheckIsAgent
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
        $theSession = json_decode(Redis::get($theToken),true);
        if($theSession['Status'] == '0')
        {
            return $next($request);
        }
        //return $next($request);
        return redirect('/');
    }
  
}
