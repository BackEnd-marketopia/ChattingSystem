<?php

namespace App\Repositories\Chat;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;


class ChatRepository implements ChatRepositoryInterface
{
    use HasRoles;

    //Create Chat
    public function createChat($data)
    {
        return Chat::create($data);
    }


    //Delete Chat
    public function deleteChat($chatId)
    {
        return Chat::findOrFail($chatId)->delete();
    }

    //Get User Chats
    public function getUserChats()
    {
        $user = Auth::user();

        if ($user->roles->contains('name', 'admin')) {
            return Chat::latest()->get();
        }

        if ($user->roles->contains('name', 'team')) {
            return Chat::whereHas('teamMembers', fn($q) => $q->where('user_id', $user->id))
                ->latest()
                ->get();
        }

        if ($user->roles->contains('name', 'client')) {
            return Chat::where('client_id', $user->id)
                ->latest()
                ->get();
        }
    }

    //Get User Chat
    public function getUserChat($chatId)
    {
        $user = Auth::user();

        if ($user->roles->contains('name', 'admin')) {
            return Chat::findOrFail($chatId);
        }

        if ($user->roles->contains('name', 'team')) {
            return Chat::whereHas('teamMembers', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->findOrFail($chatId);
        }

        if ($user->roles->contains('name', 'client')) {
            return Chat::where('client_id', $user->id)->findOrFail($chatId);
        }
    }

    // Assign Team Members
    public function assignTeamMembers($chatId, array $teamIds)
    {
        $chat = Chat::findOrFail($chatId);
        $chat->teamMembers()->sync($teamIds);
        return $chat->load('teamMembers');
    }


}
