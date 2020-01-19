<?php

namespace Modules\Log\Listeners;

use Illuminate\Auth\Events\Lockout;
use Modules\Log\Http\Traits\ActivityLogger;

class LogLockout
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
        if (config('log.log_lock_out')) {
            ActivityLogger::activity('Locked Out');
        }
    }
}
