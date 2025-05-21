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


    //step 3
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


    //step 3
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


    //step 3
    //Send Message
    // public function sendMessage($chatId, $data)
    // {
    //     return $this->chatRepo->sendMessage($chatId, $data);
    // }


    //step 4
    //Assign Team Members
    public function assignTeamMembers($chatId, array $teamIds)
    {
        return $this->chatRepo->assignTeamMembers($chatId, $teamIds);
    }


    //step 6
    //Attach Package
    // public function attachPackage($chatId, $packageId)
    // {
    //     return $this->chatRepo->attachPackage($chatId, $packageId);
    // }


}
