<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportProblem extends Mailable
{
    use Queueable, SerializesModels;

    public $description;
    public $problem;
    public $question;

    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($description ,  $problem,$question)
    {
        $this->description=$description;
        $this->problem=$problem;
        $this->question=$question;
    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
        return $this->subject('Report a Probleam by Learner')->view('mails.sendReportProblem')->with(['description' => $this->description , 'problem' => $this->problem,'question' => $this->question]);
    }
}
