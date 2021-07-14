<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GameCodeShare extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $code;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($user,$code)
    {
      $this->user = $user;
      $this->code = $code;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
        return $this->view('mails.gamecodeshare',compact(['user' => $this->user,'code' => $this->code]));
    }
}
