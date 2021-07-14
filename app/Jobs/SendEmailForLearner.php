<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\SendReportToLearner;
use Illuminate\Support\Facades\Storage;
use Mail;


class SendEmailForLearner implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $url;
    /**
     * Create a new job instance.
     *
     * return void
     */
    public function __construct($user,$url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * return void
     */
    public function handle()
    {

      Mail::to($this->user->email)->queue(new SendReportToLearner($this->user,$this->url));
      Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $this->user->email );
      Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
    }
}
