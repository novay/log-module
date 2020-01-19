<?php

namespace Modules\Log\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Modules\Log\Http\Traits\ActivityLogger;

class LogAuthenticated
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
        if (config('log.log_all_auth_events')) {
            ActivityLogger::activity('Authenticated Activity');
        }
    }
}
