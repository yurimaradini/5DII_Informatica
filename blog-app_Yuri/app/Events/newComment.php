<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class newComment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $username;

    public function __construct($username, $message)
    {
        $this->$username = $username;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $notification = $username . "ha detto: " . $message;
        //return new PrivateChannel('channel-name');
        return ['my-channel']
    }
}
