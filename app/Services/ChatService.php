<?php

namespace App\Services;

use App\Repositories\Chat\ChatRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ChatService
{
    protected $chatRepo;

    //Constructor
    public function __construct(ChatRepositoryInterface $chatRepo)
    {
        $this->chatRepo = $chatRepo;
    }


    //Create Chat
    public function createChat($data)
    {
        return $this->chatRepo->createChat($data);
    }


    //Delete Chat
    public function deleteChat($chatId)
    {
        return $this->chatRepo->deleteChat($chatId);
    }


    //Get User Chats
    public function getUserChats()
    {
        return $this->chatRepo->getUserChats();
    }


    //Get User Chat
    public function getUserChat($chatId)
    {
        try {
            return $this->chatRepo->getUserChat($chatId);
        } catch (ModelNotFoundException $e) {
            throw $e;
        }
    }


    //Assign Team Members
    public function assignTeamMembers($chatId, array $teamIds)
    {
        return $this->chatRepo->assignTeamMembers($chatId, $teamIds);
    }


    public function getUserbyChat($chatId){
        return $this->chatRepo->getUserbyChat($chatId);
    }


}
