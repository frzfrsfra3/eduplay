<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteChild extends Mailable
{
    use Queueable, SerializesModels;

    public $class_url;
    public $receiverName;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($class_url, $receiverName)
    {
        $this->class_url=$class_url;
        $this->receiverName=$receiverName;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    { 
        $class_url = $this->class_url;
        $receiverName = $this->receiverName;

        
        return $this->view('mails.inviteChild' ,compact( 'class_url' ,'receiverName'));
    }
}
