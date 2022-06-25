<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationProjectPend implements ShouldBroadcastNow
{
    use SerializesModels,Dispatchable,InteractsWithSockets,SerializesModels;
    public $invent;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($invent)
    {
        $this -> invent = $invent;
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('notificationprojectpendinvent');
    }
}
