<?php

// app/Http/Controllers/Api/ChatMessageController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessageRequest;
use App\Services\ChatService;

class ChatMessageController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function store(StoreChatMessageRequest $request, $chatId)
    {
        $message = $this->chatService->sendMessage($chatId, $request->validated());

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message,
        ]);
    }
}
