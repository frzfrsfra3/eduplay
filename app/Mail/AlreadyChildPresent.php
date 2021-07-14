<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlreadyChildPresent extends Mailable
{
    use Queueable, SerializesModels;

    public $sender;
    public $presentChild;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($sender ,  $presentChild)
    {
        $this->sender=$sender;
        $this->presentChild=$presentChild;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
        return $this->view('mails.present-child')->with(['sender' => $this->sender , 'presentChild' => $this->presentChild]);
    }
}
