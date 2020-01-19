<?php

namespace Modules\Log\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use Modules\Log\Http\Traits\ActivityLogger;

class LogPasswordReset
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
        if (config('log.log_password_reset')) {
            ActivityLogger::activity('Reset Password');
        }
    }
}
