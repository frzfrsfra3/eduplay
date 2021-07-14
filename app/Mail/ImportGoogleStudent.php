<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportGoogleStudent extends Mailable
{
    use Queueable, SerializesModels;


   public $rendompassword;
   public $sender;
   public $child;
   public $classURL;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($rendompassword,$sender ,$child,$classURL)
    {
        $this->rendompassword=$rendompassword;
        $this->sender=$sender;
        $this->child=$child;
        $this->classURL = $classURL;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
      return $this->view('mails.sendgooglestudentinvitation')->with(['rendompassword' => $this->rendompassword,'sender' => $this->sender , 'child' => $this->child,'classURL' =>$this->classURL]);
    }
}
