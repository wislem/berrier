<?php

namespace App\Http\Middleware;

use App\Models\Notification;
use Closure;

class NotificationsRead
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
        if(\Auth::check()) {
            $notifications = \Auth::user()->notifications(0)->where('uri', '=', $request->getRequestUri());
            if ($notifications->count()) {
                $notifications->update(['is_read' => 1]);
            }
        }

        return $next($request);
    }
}
