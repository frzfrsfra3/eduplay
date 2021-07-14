<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Marquine\Etl\Etl;


use Log;
use Illuminate\Support\Facades\Storage;


class ReportsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sender;

    /**
     * Create a new job instance.
     */
    public function __construct(User $sender )
    {
       $this->sender=$sender;
    }


    /**
     * Execute the job.
     */
    public function handle(   )
    {
        try {
            // dd('etl Reports handle start');
            $etl=new Etl();
            $options=['connection' => 'app', 'columns' => ['id', 'name', 'email'], 'where' => ['status' => 'active']];

            $etl->start()->extract('table', 'userexamanswers',$options)
                ->load('table', 'users');
        } catch (Exception $exception) {
            Storage::disk ('local')->append ("Etljob_error.txt", $exception);

        }

    }

    public function failed($exception)
    {
        $exception->getMessage();
        Storage::disk ('local')->append ("Etljob_error.txt", $exception);
    }

}
