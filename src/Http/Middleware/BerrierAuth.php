<?php
namespace Wislem\Berrier\Http\Middleware;

use Auth;
use Closure;

class BerrierAuth
{
    public function handle($request, Closure $next)
    {
        if (Auth::guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('admin/auth/login');
            }
        }else {
            if(Auth::user()->cannot('access-admin')) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->guest('admin/auth/login');
                }
            }
        }

        return $next($request);
    }
}