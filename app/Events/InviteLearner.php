<?php

namespace App\Events;

use App\Models\Courseclass;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class InviteLearner
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $courseclass;
    public $learner_id;
    /**
     * Create a new event instance.
     */
    public function __construct( $learner_id  ,Courseclass  $courseclass)
    {
        $this->Courseclass= $courseclass;
        $this->learner_id= $learner_id;

    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }


}
