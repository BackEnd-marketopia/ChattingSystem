<?php

namespace App\Repositories\Chat;

interface ChatRepositoryInterface
{
    //create chat
    public function createChat($data);

    //delete chat
    public function deleteChat($chatId);

    //get user chats
    public function getUserChats();

    //get user chat
    public function getUserChat($chatId);

    //assign team members to chat
    public function assignTeamMembers($chatId, array $teamIds);

    //get user by chat
    public function getUserbyChat($chatId);

}
