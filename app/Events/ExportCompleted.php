<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExportCompleted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel('exports.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'export.completed';
    }
}
