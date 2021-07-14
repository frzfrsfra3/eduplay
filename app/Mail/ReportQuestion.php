<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ReportQuestion extends Mailable
{
    use Queueable, SerializesModels;
    //public $confirmation_code;
    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct()
    {

        //
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build(   )
    {

        Storage::disk ('local')->append ('mailparentsent.txt', 'send mail to Teacher');
        return $this->view('mails.reportquestion' );
    }
}
