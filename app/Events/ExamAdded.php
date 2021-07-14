<?php

namespace App\Events;

use App\Models\Exam;
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


class ExamAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $course;
    public $exam;
    /**
     * Create a new event instance.
     *
     * return void
     */
    public function __construct( Courseclass $course , Exam  $exam)
    {
        // when teacher accept or reject a learner request
        $this->course=$course;
        $this->exam=$exam;

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
