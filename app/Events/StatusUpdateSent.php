<?php

namespace App\Events;

use App\Models\ProjectStatusUpdate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StatusUpdateSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $statusUpdate ;

    /**
     * Create a new event instance.
     *
     * @param ProjectStatusUpdate $statusUpdate
     */
    public function __construct(ProjectStatusUpdate $statusUpdate)
    {
        //
        $this->statusUpdate = $statusUpdate;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('jobs233-project-'.$this->statusUpdate->project_id);
    }
}
