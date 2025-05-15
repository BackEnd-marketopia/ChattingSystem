<?php

// app/Repositories/ChatMessageRepositoryInterface.php

namespace App\Repositories\ChatMessage;

interface ChatMessageRepositoryInterface
{
    //step 8
    public function getMessagesByChat($chatId);

    //step 7  (create)
    public function sendMessage(array $data);
    
}
