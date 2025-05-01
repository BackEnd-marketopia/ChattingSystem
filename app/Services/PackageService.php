<?php

use App\Repositories\Chat\ChatRepositoryInterface;
use App\Repositories\Package\PackageRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use App\Events\NewMessageEvent;


class PackageService
{
    public function __construct(protected PackageRepositoryInterface $packageRepo, protected ChatRepositoryInterface $chatRepo)
    {
        $this->packageRepo = $packageRepo;
        $this->chatRepo = $chatRepo;
    }

    public function createPackage($clientId, $limits)
    {
        return $this->packageRepo->createPackage($clientId, $limits);
    }

    public function addItem($packageId, $data)
    {
        $item = $this->packageRepo->addItem($packageId, $data);

        $chat = $this->chatRepo->getChatByPackage($packageId);

        if ($chat) {

            $filePath = null;

            $data = [
                'sender_id' => Auth::id(),
                'message' => 'A new item has been added to the package: ' . $data['type'],
                'file_path' =>  $filePath,
            ];

            // Create a system message in the chat
            $message = $this->chatRepo->sendMessage($chat->id, $data);

            // Broadcast the message event (Laravel Reverb/WebSocket)
            broadcast(new NewMessageEvent($message))->toOthers();
        }

        return $item;
    }

    public function updateItemStatus($itemId, $status)
    {
        return $this->packageRepo->updateItemStatus($itemId, $status);
    }

    public function getClientItems($clientId)
    {
        return $this->packageRepo->getClientPackageItems($clientId);
    }
}
