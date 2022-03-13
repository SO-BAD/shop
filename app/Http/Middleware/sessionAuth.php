<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class sessionAuth
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

        $path = $request->path();

        if(session('manager')){
            if($path =='login'|| $path =='register'){
                return redirect('/');
            }
        }else{
            if($path =='addMenuPage'){
                return redirect('/');
            }
        }
        return $next($request);
    }
}
