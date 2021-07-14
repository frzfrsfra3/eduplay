<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use PhpParser\Node\Scalar\String_;
use Exception;

class CompleteProfile
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $profilepercent;
    /**
     * Create a new event instance.
     *
     * return void
     */
    public function __construct(  $profilepercent  )
    {

        $this->profilepercent=$profilepercent;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
