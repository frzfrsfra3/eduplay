<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\InviteFriendMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Log;



class SendInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $confirmation_code;
    protected $sender;
    protected $inviteduser;
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * return void
     */
    public function handle(   )
    {
        try {

           
            Mail::to($this->inviteduser->email)->send (new InviteFriendMail (   $this->confirmation_code , $this->sender ,  $this->inviteduser));
            Storage::disk ('local')->append('emailing.txt', "Send Mail: \r\nTo:" . $this->inviteduser->email );
            Storage::disk ('local')->append('api.register.txt', '------------------------------------------------------------------------------------------------------------------------------------');
      
        } catch (Exception $exception) {
            Storage::disk ('local')->append ('jobsendingmail_error.txt', $exception);

        }

    }

}
