<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteNonRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $class_url;
    public $register_url;
    public $receiverEmail;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($class_url, $register_url, $receiverEmail)
    {
        $this->class_url=$class_url;
        $this->register_url = $register_url;
        $this->receiverEmail=$receiverEmail;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    { 
        $class_url = $this->class_url;
        $register_url = $this->register_url;
        $receiverEmail = $this->receiverEmail;

        
        return $this->view('mails.courseclass' ,compact( 'class_url','register_url' ,'receiverEmail'));
    }
}
