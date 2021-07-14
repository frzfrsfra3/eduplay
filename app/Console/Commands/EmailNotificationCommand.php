<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EmailNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:Emailnotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * return mixed
     */
    public function handle()
    {
         \Log::info("Emailnotification Cummand Run successfully!");
         //Call daily email notification logic.

         app('App\Http\Controllers\Mails\MailController')->checkInThreeDayUserLoggedIn();
     
    }
}
