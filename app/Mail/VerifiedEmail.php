<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifiedEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $token;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($user, $token)
    {
        $this->user=$user;
        $this->token=$token;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
        $user = $this->user;
        $token = $this->token;
        return $this->view('mails.verifiedEmail',compact('user','token'));
    }
}
