<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReportToTeachers extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $url;
    public $students;
    public $fromDate;
    public $toDate;
    /**
     * Create a new message instance.
     *
     * return void
     */
    public function __construct($user, $url, $students, $fromDate, $toDate)
    {
      $this->user = $user;
      $this->url = $url;
      $this->students = $students;
      $this->fromDate = $fromDate;
      $this->toDate = $toDate;

    }

    /**
     * Build the message.
     *
     * return $this
     */
    public function build()
    {
      return $this->view('mails.notification.teachernotsingin',['user' => $this->user, 'url' => $this->url, 'students' => $this->students, 'fromDate' => $this->fromDate, 'toDate' => $this->toDate]);
    }
}
