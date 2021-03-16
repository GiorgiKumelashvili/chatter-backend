<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessage implements ShouldBroadcast {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;

    public function __construct(array $request) {
        $this->data = $request;
    }

    public function broadcastOn(): Channel {
        return new Channel('send-message-channel');
    }
}
