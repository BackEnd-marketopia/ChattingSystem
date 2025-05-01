<?php

// app/Services/ChatMessageService.php

namespace App\Services;

use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\NewMessageEvent;
use App\Repositories\ChatMessageRepositoryInterface;

class ChatMessageService
{
    protected $chatMessageRepo;

    public function __construct(ChatMessageRepositoryInterface $chatMessageRepo)
    {
        $this->chatMessageRepo = $chatMessageRepo;
    }

    public function sendMessage($chatId, $data)
    {
        $filePath = null;

        if (isset($data['file'])) {
            $filePath = $data['file']->store("chats/{$chatId}", 'public');
        }

        $message = $this->chatMessageRepo->createChatMessage($chatId, $filePath, $data);

        broadcast(new NewMessageEvent($message))->toOthers();

        return $message;
    }
}
