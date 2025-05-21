<?php

// app/Repositories/ChatMessageRepository.php

namespace App\Repositories\ChatMessage;

use App\Models\Chat;
use App\Models\ChatMessage;

class ChatMessageRepository implements ChatMessageRepositoryInterface
{
    //step 8
    public function getMessagesByChat($chatId)
    {
        $chat = Chat::findOrFail($chatId);
        $messages = ChatMessage::with('sender')
            ->where('chat_id', $chat->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);


        $messages = $messages->toArray();
        $messages['data'] = array_reverse($messages['data']);
        return $messages;
    }

    //step 7  (create)
    public function sendMessage(array $data)
    {
        $message = Chat::findOrFail($data['chat_id']);
        if ($message) {
            return ChatMessage::create($data);
        }
    }
}
