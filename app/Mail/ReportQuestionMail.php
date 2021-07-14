<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Exerciseset;
use App\Models\Question;
use App\Models\User;

class ReportQuestionMail extends Mailable
{
    use Queueable, SerializesModels;
    //public $confirmation_code;
    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($user,$question,$textreport)
    {
        $this->question=$question;
        $this->user=$user;
        $this->textreport=$textreport;

        //
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build(   )
    { $question=$this->question;
        $user=$this->user;
        $textreport=$this->textreport;
        if(strlen($textreport)==0){$textreport='&nbsp;';}

        Storage::disk ('local')->append ('mailparentsent.txt', 'send mail to Teacher');
        return $this->view('mails.reportquestion',compact('user','question','textreport') );
    }
}
