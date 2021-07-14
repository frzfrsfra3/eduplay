<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class InviteChildMail extends Mailable
{
    use Queueable, SerializesModels;


   public $rendompassword;
   public $sender;
   public $child;
   public $url;
    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($url, $rendompassword,$sender ,$child)
    {
            $this->rendompassword=$rendompassword;
            $this->sender=$sender;
            $this->child=$child;
            $this->url=$url;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
        // Storage::disk ('local')->append ('invitechild_start.txt',"sasasas" );
        return $this->view('mails.sendchildinvitation')->with(['url' => $this->url,'rendompassword' => $this->rendompassword,'sender' => $this->sender , 'child' => $this->child]);
    }
}
