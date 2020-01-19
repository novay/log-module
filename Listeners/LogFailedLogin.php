<?php

namespace Modules\Log\Listeners;

use Illuminate\Auth\Events\Failed;
use Modules\Log\Http\Traits\ActivityLogger;

class LogFailedLogin
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
        if (config('log.log_failed_auth_attempts')) {
            ActivityLogger::activity('Failed Login Attempt');
        }
    }
}
