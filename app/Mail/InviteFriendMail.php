<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class InviteFriendMail extends Mailable
{
    use Queueable, SerializesModels;


    protected $confirmation_code;
    protected $sender;
    protected $inviteduser;
    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($confirmation_code ,$sender ,$inviteduser)
    {
            $this->confirmation_code=$confirmation_code;
            $this->sender=$sender;
            $this->inviteduser=$inviteduser;
        //
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build(   )
    {

        return $this->view('mails.sendinvitation' );
    }
}
