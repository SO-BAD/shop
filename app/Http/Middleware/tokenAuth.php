<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ManagerLoginTokens;

class tokenAuth
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
        // if(!$request->ajax()){
        //    abort(404);
        // }
        // echo "<pre>";
        // print_r($request->header());
        // echo "</pre>";

        if (!$request->ajax()) {
            abort(404);
        } else {
            if ($request->hasHeader('Authorization')) {
                $token = str_replace("Bearer ", "", $request->header('Authorization'));
                $data = ManagerLoginTokens::where('token', $token);

                if ($data->count()) {
                    return $next($request);
                }
            }
            if (session()->has('manager')) {
                session()->forget('manager');
            }
            $res = ['status' => 0, 'msg' => 'Unauthorized'];
            return response()->json($res, 401);
        }
    }
}
