<?php

namespace App\Jobs;

use App\Mail\InviteChildMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


use Log;
use Illuminate\Support\Facades\Storage;


class AddChildJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 //   public $confirmation_code;
 //   public $sender;
 //   public $inviteduser;
    public $sender;
    /**
     * Create a new job instance.
     *
     * return void
     */
    public function __construct(User $sender )
    {
       /* $this->confirmation_code=$confirmation_code;
        $this->sender=$sender;
        $this->inviteduser=$inviteduser; */
       $this->sender=$sender;

        //
    }


    /**
     * Execute the job.
     *
     * return void
     */
    public function handle(   )
    {
        try {

            // dd('handel start');
            $data=$this->sender;

            Mail::to($this->sender->email)->send (new InviteChildMail (   ));
            Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $this->sender->email );
            Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
    
        } catch (Exception $exception) {
            Storage::disk ('local')->append ("jobsendingmail_error.txt", $exception);

        }

    }

    public function failed($exception)
    {
        $exception->getMessage();
        Storage::disk ('local')->append ("jobsendingmail_error.txt", $exception);
        // etc...
    }

}
