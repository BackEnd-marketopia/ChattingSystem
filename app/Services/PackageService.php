<?php

namespace App\Services;

use App\Repositories\Package\PackageRepositoryInterface;



class PackageService
{
    protected $repository;

    public function __construct(PackageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    // public function __construct(protected PackageRepositoryInterface $packageRepo, protected ChatRepositoryInterface $chatRepo)
    // {
    //     $this->packageRepo = $packageRepo;
    //     $this->chatRepo = $chatRepo;
    // }

    // //step 5
    // public function createPackage($clientId, $limits)
    // {
    //     return $this->packageRepo->createPackage($clientId, $limits);
    // }

    // //step 5
    // //step 6
    // public function addItem($packageId, $data)
    // {
    //     $item = $this->packageRepo->addItem($packageId, $data);

    //     $chat = $this->chatRepo->getChatByPackage($packageId);

    //     if ($chat) {

    //         $filePath = null;

    //         $data = [
    //             'sender_id' => Auth::id(),
    //             'message' => 'A new item has been added to the package: ' . $data['type'],
    //             'file_path' =>  $filePath,
    //         ];

    //         // Create a system message in the chat
    //         $message = $this->chatRepo->sendMessage($chat->id, $data);

    //         // Broadcast the message event (Laravel Reverb/WebSocket)
    //         broadcast(new NewMessageEvent($message))->toOthers();
    //     }

    //     return $item;
    // }

    // //step 5
    // public function updateItemStatus($itemId, $status)
    // {
    //     return $this->packageRepo->updateItemStatus($itemId, $status);
    // }

    // //step 5
    // public function getClientItems($clientId)
    // {
    //     return $this->packageRepo->getClientPackageItems($clientId);
    // }



    public function listPackages()
    {
        return $this->repository->getAll();
    }

    public function getPackage($id)
    {
        return $this->repository->findById($id);
    }

    public function createPackage(array $data)
    {
        $package = $this->repository->create($data);
        
        if (isset($data['file'])) {
            $filePath = $data['file']->store("packages/{$package->id}", 'public');
            $package->file_path = '/storage/' . $filePath;
            $package->save();
        }
        
        return $package;
    }

    public function updatePackage($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deletePackage($id)
    {
        return $this->repository->delete($id);
    }
}
