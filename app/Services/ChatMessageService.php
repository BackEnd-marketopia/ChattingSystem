<?php

// app/Services/ChatMessageService.php

namespace App\Services;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\NewMessageEvent;
use App\Repositories\ChatMessage\ChatMessageRepositoryInterface;

class ChatMessageService
{
    protected $chatMessageRepo;

    // Constructor
    public function __construct(ChatMessageRepositoryInterface $chatMessageRepo)
    {
        $this->chatMessageRepo = $chatMessageRepo;
    }

    // Get messages of a chat
    public function getMessages($chatId)
    {
        return $this->chatMessageRepo->getMessagesByChat($chatId);
    }

    // Send a message to a chat
    public function sendMessage($chatId, $data)
    {
        $messageData = [
            'chat_id' => $chatId,
            'sender_id' => $data['senderId'] ?? Auth::id(),
            'message' => $data['message'] ?? null,
            'media' => $data['media'] ?? null,
            'client_package_item_id' => $data['client_package_item_id'] ?? null,

            'item_type' => $data['item_type'] ?? null,
            'package_item_id' => $data['package_item_id'] ?? null,
            'client_package_id' => $data['client_package_id'] ?? null,
            'client_note' => $data['client_note'] ?? null,
            'IsItem' => $data['IsItem'] ?? null
        ];

        $message = $this->chatMessageRepo->sendMessage($messageData);

        broadcast(new NewMessageEvent($message))->toOthers();

        return $message;
    }
}
