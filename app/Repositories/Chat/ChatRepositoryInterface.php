<?php

namespace App\Repositories\Chat;

interface ChatRepositoryInterface
{
    public function createChat($clientId);
    public function getUserChats($user);
    public function sendMessage($chatId, $data);
    public function assignTeamMembers($chatId, array $teamIds);

    public function attachPackage($chatId, $packageId);
    public function getChatByPackage($packageId);
}
