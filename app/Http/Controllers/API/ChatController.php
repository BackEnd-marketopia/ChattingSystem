<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\ChatService;
use App\Http\Requests\ChatRequest;
use App\Http\Requests\AssignTeamRequest;
use App\Http\Requests\AttachPackageRequest;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChatController extends Controller
{
    protected $chatService;

    //Constructor
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    //Create Chat
    public function createChat(ChatRequest $request)
    {
        $chat = $this->chatService->createChat($request->all());
        return Response::api('Chat created successfully', 201, true, 201, $chat);
    }

    //Delete Chat
    public function deleteChat($chatId)
    {
        $chat = $this->chatService->deleteChat($chatId);
        return Response::api('Chat deleted successfully', 200, true, 200, $chat);
    }

    //Get User Chats
    public function getUserChats()
    {
        $chats = $this->chatService->getUserChats();
        return Response::api('Chats retrieved successfully', 200, true, 200, $chats);
    }

    //Get User Chat
    public function getUserChat($chatId)
    {
        try {
            $chat = $this->chatService->getUserChat($chatId);
            return Response::api('Chat retrieved successfully', 200, true, 200, $chat);
        } catch (ModelNotFoundException $e) {
            return Response::api('Chat not found', 404, false, 404);
        }
    }

    //Assign Team
    public function assignTeam(AssignTeamRequest $request, $chatId)
    {
        $chat = $this->chatService->assignTeamMembers($chatId, $request->team_ids);
        return Response::api('Team members assigned successfully', 200, true, 200, $chat);
    }

    public function getUserbyChat($chatId){
        $user = $this->chatService->getUserbyChat($chatId);
        return Response::api('User retrieved successfully', 200, true, 200, $user);
    }


}
