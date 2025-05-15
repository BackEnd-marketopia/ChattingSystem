<?php

namespace App\Services;

use App\Repositories\ClientPackageItem\ClientPackageItemRepositoryInterface;
use App\Events\ItemStatusUpdatedEvent;
use Illuminate\Support\Facades\Auth;

class ClientPackageItemService
{
    protected $clientPackageItemRepo;

    public function __construct(ClientPackageItemRepositoryInterface $clientPackageItemRepo)
    {
        $this->clientPackageItemRepo = $clientPackageItemRepo;
    }

    public function editItem($itemId, array $data)
    {
        $item = $this->clientPackageItemRepo->find($itemId);
        $item = $this->clientPackageItemRepo->update($itemId, $data);

        $this->clientPackageItemRepo->createHistory([
            'client_package_item_id' => $item->id,
            'status' => $item->status,
            'note' => $data['note'] ?? '',
            'updated_by' => Auth::id(),
        ]);

        event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

        return $item;
    }

    public function declineItem($itemId, array $data = [])
    {
        $item = $this->clientPackageItemRepo->find($itemId);
        $item = $this->clientPackageItemRepo->update($itemId, [
            'status' => 'declined',
            ...$data,
        ]);

        $this->clientPackageItemRepo->createHistory([
            'client_package_item_id' => $item->id,
            'status' => 'declined',
            'note' => $data['note'] ?? '',
            'updated_by' => Auth::id(),
        ]);

        event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

        return $item;
    }

    public function acceptItem($itemId)
    {
        $item = $this->clientPackageItemRepo->find($itemId);
        $item = $this->clientPackageItemRepo->update($itemId, ['status' => 'accepted']);

        $this->clientPackageItemRepo->createHistory([
            'client_package_item_id' => $item->id,
            'status' => 'accepted',
            'note' => 'Accepted by admin',
            'updated_by' => Auth::id(),
        ]);

        event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

        return $item;
    }
}
