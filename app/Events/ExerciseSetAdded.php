<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Courseclass;
use PhpParser\Node\Scalar\String_;
use Exception;


class ExerciseSetAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $course;
    /**
     * Create a new event instance.
     *
     * return void
     */
    public function __construct( Courseclass $course  )
    {
        // when teacher accept or reject a learner request
        $this->course=$course;

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
