<?php

// app/Repositories/ChatMessageRepositoryInterface.php

namespace App\Repositories\ChatMessage;

interface ChatMessageRepositoryInterface
{
    // Get messages of a chat
    public function getMessagesByChat($chatId);

    // Send a message to a chat
    public function sendMessage(array $data);
    
}
