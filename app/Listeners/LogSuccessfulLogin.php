<?php

namespace App\Listeners;

use App\Models\LoginActivity;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Traits\AddXppoint;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * return void
     */
    use AddXppoint;

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * param  Login  $event
     * return void
     */
    public function handle(Login $event)
    {
        $this->add_xp_point($event->user->id ,'login');
        LoginActivity::create([
            'user_id'       =>  $event->user->id,
            'user_agent'    =>  \Illuminate\Support\Facades\Request::header('User-Agent'),
            'ip_address'    =>  \Illuminate\Support\Facades\Request::ip()
        ]);
    }
}
