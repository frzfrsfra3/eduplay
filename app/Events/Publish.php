<?php

namespace App\Events;

use App\Models\Discipline;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Publish
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $discipline;
    /**
     * Create a new event instance.
     *
     * return void
     */
    public function __construct(Discipline $discipline)
    {
        //
        $this->discipline=$discipline;

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
