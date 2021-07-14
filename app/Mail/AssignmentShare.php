<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Exam;

class AssignmentShare extends Mailable
{
    use Queueable, SerializesModels;


    public $url;
    public $receiverEmail;
    public $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $receiverEmail, $id)
    {
        $this->url=$url;
        $this->receiverEmail=$receiverEmail;
        $this->id=$id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.assignment' ,compact( 'url' ,'receiverEmail' , 'id'));
    }
}
