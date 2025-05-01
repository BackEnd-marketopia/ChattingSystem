<?php

namespace App\Services;

use App\Repositories\Chat\ChatRepositoryInterface;

class ChatService
{
    protected $chatRepo;

    public function __construct(ChatRepositoryInterface $chatRepo)
    {
        $this->chatRepo = $chatRepo;
    }

    public function createChat($clientId)
    {
        return $this->chatRepo->createChat($clientId);
    }

    public function getUserChats($user)
    {
        return $this->chatRepo->getUserChats($user);
    }

    public function sendMessage($chatId, $data)
    {
        return $this->chatRepo->sendMessage($chatId, $data);
    }

    public function assignTeamMembers($chatId, array $teamIds)
    {
        return $this->chatRepo->assignTeamMembers($chatId, $teamIds);
    }


    public function attachPackage($chatId, $packageId)
    {
        return $this->chatRepo->attachPackage($chatId, $packageId);
    }

    public function getChatByPackage($packageId)
    {
        return $this->chatRepo->getChatByPackage($packageId);
    }
}
