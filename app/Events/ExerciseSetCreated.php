<?php

namespace App\Events;

use App\Models\Exerciseset;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use PhpParser\Node\Scalar\String_;
use Exception;

class ExerciseSetCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $exersiseset;
    /**
     * Create a new event instance.
     *
     * return void
     */
    public function __construct( Exerciseset $exersiseset  )
    {
        // when teacher accept or reject a learner request
        $this->exersiseset=$exersiseset;

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
