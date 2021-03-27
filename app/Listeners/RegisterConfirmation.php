<?php

namespace App\Listeners;

use App\Events\Register;
use App\Mail\RegisterMail;
use Illuminate\Support\Facades\Mail;

class RegisterConfirmation
{
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
     * @param  Register  $event
     * @return void
     */
    public function handle(Register $event)
    {
        $user = $event->user;

        Mail::to($user->email)->send(new RegisterMail($user));
    }
}
