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

    public function __construct(ChatMessageRepositoryInterface $chatMessageRepo)
    {
        $this->chatMessageRepo = $chatMessageRepo;
    }

    //step 8
    public function getMessages($chatId)
    {
        return $this->chatMessageRepo->getMessagesByChat($chatId);
    }

    //step 7
    public function sendMessage($chatId, $data)
    {
        $filePath = null;

        if (isset($data['file'])) {
            $filePath = $data['file']->store("chats/{$chatId}", 'public');
        }

        $messageData = [
            'chat_id' => $chatId,
            'sender_id' => Auth::id(),
            'message' => $data['message'] ?? null,
            'file_path' => $filePath,
        ];

        $message = $this->chatMessageRepo->sendMessage($messageData);

        broadcast(new NewMessageEvent($message))->toOthers();

        return $message;
    }
}
