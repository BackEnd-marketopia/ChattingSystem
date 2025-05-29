<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessageRequest;
use App\Services\ChatService;
use App\Services\ChatMessageService;
use Illuminate\Support\Facades\Response;

class ChatMessageController extends Controller
{
    protected $chatService;
    protected $chatMessageService;

    // Constructor
    public function __construct(ChatService $chatService, ChatMessageService $chatMessageService)
    {
        $this->chatService = $chatService;
        $this->chatMessageService = $chatMessageService;
    }

    // get messages of a chat
    public function getMessages($chatId)
    {
        $messages = $this->chatMessageService->getMessages($chatId);
        return Response::api('Messages retrieved successfully', 200, true, 200, $messages);
    }

    // send a message to a chat
    public function sendMessage(StoreChatMessageRequest $request, $chatId)
    {
        $message = $this->chatMessageService->sendMessage($chatId, $request->validated());
        return Response::api('Message sent successfully', 201, true, 201, $message);
    }
}
