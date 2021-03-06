<?php

namespace Modules\Log\Listeners;

use Illuminate\Auth\Events\Logout;
use Modules\Log\Http\Traits\ActivityLogger;

class LogSuccessfulLogout
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
        if (config('log.log_successful_logout')) {
            ActivityLogger::activity('Logged Out');
        }
    }
}
