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

class EnrollRequested
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $courseclass;
    /**
     * Create a new event instance.
     */
    public function __construct(Courseclass $courseclass)
    {
        $this->Courseclass= $courseclass;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }


}
