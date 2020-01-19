<?php

namespace Modules\Log\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Modules\Log\Http\Traits\ActivityLogger;

class LogActivity
{
    use ActivityLogger;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $description = null)
    {
        if ($this->shouldLog($request)) {
            ActivityLogger::activity($description);
        }

        return $next($request);
    }

    /**
     * Determine if the request has a URI that should log.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function shouldLog($request)
    {
        return true;
    }
}
