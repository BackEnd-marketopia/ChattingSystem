<?php

namespace App\Repositories\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;

class ChatRepository implements ChatRepositoryInterface
{
    public function createChat($clientId)
    {
        return Chat::create(['client_id' => $clientId]);
    }

    public function getUserChats($user)
    {
        if ($user->hasRole('admin')) {
            return Chat::all();
        }

        if ($user->hasRole('team')) {
            return Chat::whereHas('teamMembers', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->get();
        }

        return Chat::where('client_id', $user->id)->get();
    }

    public function sendMessage($chatId, $data)
    {
        return ChatMessage::create([
            'chat_id'   => $chatId,
            'sender_id' => $data['senderId'],
            'message'   => $data['message'] ?? null,
            'file_path' => $data['file_path'] ?? null,
        ]);
    }

    public function assignTeamMembers($chatId, array $teamIds)
    {
        $chat = Chat::findOrFail($chatId);
        $chat->teamMembers()->sync($teamIds);
        return $chat->load('teamMembers');
    }

    public function attachPackage($chatId, $packageId)
    {
        $chat = Chat::findOrFail($chatId);
        $chat->packages()->syncWithoutDetaching([$packageId]);
        return $chat->load('packages');
    }

    public function getChatByPackage($packageId)
    {
        return Chat::whereHas('packages', function ($q) use ($packageId) {
            $q->where('package_id', $packageId);
        })->first();
    }
}
