<?php

namespace App\Repositories\Chat;

interface ChatRepositoryInterface
{
    //step 3
    public function createChat($clientId);

    public function deleteChat($chatId);

    //step 3
    public function getUserChats();

    public function getUserChat($chatId);

    //step 3
    // public function sendMessage($chatId, $data);

    //step 4
    public function assignTeamMembers($chatId, array $teamIds);

    //step 6
    // public function attachPackage($chatId, $packageId);


}
