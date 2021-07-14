<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendReportToTeachers;
use Illuminate\Support\Facades\Storage;

use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $url;
    public $students;
    public $fromDate;
    public $toDate;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * return void
     */
    public function handle()
    {
      Mail::to($user->email)->queue(new SendReportToTeachers( $this->user, $this->url, $this->students, $this->fromDate, $this->toDate));
      Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $user->email );
      Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    }
}
