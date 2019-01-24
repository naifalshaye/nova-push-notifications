<?php

namespace Naif\NovaPushNotification\Http\Middleware;

use Naif\NovaPushNotification\NovaPushNotification;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(NovaPushNotification::class)->authorize($request) ? $next($request) : abort(403);
    }
}
