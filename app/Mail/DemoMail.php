<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class DemoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $confirmation_code;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($confirmation_code, $user)
    {
        $this->confirmation_code = $confirmation_code;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
        $cc = $this->confirmation_code;
        $user = $this->user;
        Storage::disk('local')->append('mailparentsent.txt', 'send mail to parent' . $this->confirmation_code);
        return $this->subject('Verify your parent account')->view('mails.demo', compact('cc', 'user'));
    }
}