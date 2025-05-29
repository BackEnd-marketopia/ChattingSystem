<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewMessageEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message->load('sender');
    }


    public function broadcastOn(): Channel
    {
        return new Channel('chat.' . $this->message->chat_id);
    }

    public function broadcastWith(): array
    {
        return [
            'status' => true,
            'errorNum' => 200,
            'message' => 'Message sent successfully',
            'data' => [
                'id' => $this->message->id,
                'chat_id' => $this->message->chat_id,
                'sender_id' => $this->message->sender_id,
                'message' => $this->message->message,
                'media_files' => $this->message->mediaFiles->map(function($media) {
                    return [
                        'id' => $media->id,
                        'file_path' => $media->file_path,
                        'file_type' => $media->file_type
                    ];
                }),
                'created_at' => $this->message->created_at->toDateTimeString()
            ]
        ];
    }
}
