<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    protected $chatService;

    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    public function createChat(Request $request)
    {
        $chat = $this->chatService->createChat($request->client_id);
        return response()->json($chat);
    }

    public function getUserChats(Request $request)
    {
        $chats = $this->chatService->getUserChats($request->user());
        return response()->json($chats);
    }

    public function sendMessage(Request $request, $chatId)
    {
        $data = $request->only('message', 'file_path', 'sender_id');
        $message = $this->chatService->sendMessage($chatId, $data);

        return response()->json($message);
    }

    public function assignTeam(Request $request, $chatId)
    {
        $request->validate([
            'team_ids' => 'required|array',
            'team_ids.*' => 'exists:users,id'
        ]);

        $chat = $this->chatService->assignTeamMembers($chatId, $request->team_ids);
        return response()->json($chat);
    }

    public function attachPackage(Request $request)
    {
        $data = $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'package_id' => 'required|exists:packages,id',

        ]);

        $chat = $this->chatService->attachPackage($data['chat_id'], $data['package_id']);
        return response()->json($chat);
    }
}
