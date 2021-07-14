<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassworsword extends Mailable
{
    use Queueable, SerializesModels;
    protected $response;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($response)
    {
      $this->response =  $response;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
        return $this->subject('Reset Password')
        ->markdown('mails.resetpassword')
        ->with(['response' => $this->response]);
    }
}
