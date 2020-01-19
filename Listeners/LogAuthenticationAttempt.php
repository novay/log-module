<?php

namespace Modules\Log\Listeners;

use Illuminate\Auth\Events\Attempting;
use Modules\Log\Http\Traits\ActivityLogger;

class LogAuthenticationAttempt
{
    use ActivityLogger;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if (config('log.log_auth_attempts')) {
            ActivityLogger::activity('Authenticated Attempt');
        }
    }
}
