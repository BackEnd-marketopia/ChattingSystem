<?php

namespace App\Services;

use App\Repositories\ClientPackageItem\ClientPackageItemRepositoryInterface;
use App\Events\ItemStatusUpdatedEvent;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientPackageItem;
use App\Models\ClientLimit;
use App\Models\PackageAllowedItem;
use App\Models\ItemStatusHistory;
use App\Models\ItemUsageLog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Repositories\ClientLimit\ClientLimitRepositoryInterface;


class ClientPackageItemService
{
    protected $clientPackageItemRepo;
    protected $clientLimitRepo;

    public function __construct(
        ClientPackageItemRepositoryInterface $clientPackageItemRepo,
        ClientLimitRepositoryInterface $clientLimitRepo
    ) {
        $this->clientPackageItemRepo = $clientPackageItemRepo;
        $this->clientLimitRepo = $clientLimitRepo;
    }

    // public function getItemsByClientPackage($clientPackageId)
    // {
    //     return $this->clientPackageItemRepo->getItemsByClientPackage($clientPackageId);
    // }

    // public function getItemByClientPackage($clientPackageId, $itemId)
    // {
    //     return $this->clientPackageItemRepo->getItemByClientPackage($clientPackageId, $itemId);
    // }

    // public function createItem($clientPackageId, array $data)
    // {
    //     return $this->clientPackageItemRepo->create($clientPackageId, $data);
    // }

    // public function updateItem($clientPackageId, $itemId, array $data)
    // {
    //     return $this->clientPackageItemRepo->update($clientPackageId, $itemId, $data);
    // }

    // public function deleteItem($clientPackageId, $itemId)
    // {
    //     return $this->clientPackageItemRepo->delete($clientPackageId, $itemId);
    // }


    // public function editItemStatus($itemId, array $data)
    // {
    //     $item = $this->clientPackageItemRepo->findItem($itemId);
    //     $item = $this->clientPackageItemRepo->updateItem($itemId, $data);

    //     $this->clientPackageItemRepo->createHistory([
    //         'client_package_item_id' => $item->id,
    //         'status' => $item->status,
    //         'note' => $data['note'] ?? '',
    //         'updated_by' => Auth::id(),
    //     ]);

    //     event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

    //     return $item;
    // }

    // public function declineItemStatus($itemId, array $data = [])
    // {
    //     $item = $this->clientPackageItemRepo->findItem($itemId);
    //     $item = $this->clientPackageItemRepo->updateItem($item->client_package_id, $itemId, [
    //         'status' => 'declined',
    //         ...$data,
    //     ]);

    //     $this->clientPackageItemRepo->createHistory([
    //         'client_package_item_id' => $item->id,
    //         'status' => 'declined',
    //         'note' => $data['note'] ?? '',
    //         'updated_by' => Auth::id(),
    //     ]);

    //     event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

    //     return $item;
    // }

    // public function acceptItemStatus($itemId)
    // {
    //     $item = $this->clientPackageItemRepo->findItem($itemId);
    //     $item = $this->clientPackageItemRepo->updateItem($itemId, ['status' => 'accepted']);

    //     $this->clientPackageItemRepo->createHistory([
    //         'client_package_item_id' => $item->id,
    //         'status' => 'accepted',
    //         'note' => 'Accepted by admin',
    //         'updated_by' => Auth::id(),
    //     ]);

    //     event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

    //     return $item;
    // }



    public function getAll($clientPackageId)
    {
        return $this->clientPackageItemRepo->getByClientPackage($clientPackageId);
    }

    public function getById($clientPackageId, $id)
    {
        return $this->clientPackageItemRepo->show($clientPackageId, $id);
    }

    public function store($clientPackageId, array $data)
    {
        if (isset($data['media'])) {
            $mediaPath = $data['media']->store('client_package_items_media', 'public');
            $data['media_url'] = '/storage/' . $mediaPath;
        }

        unset($data['media']);

        return $this->clientPackageItemRepo->store($clientPackageId, $data);
    }

    public function update($clientPackageId, $id, array $data)
    {
        if (isset($data['media'])) {
            $mediaPath = $data['media']->store('client_package_items_media', 'public');
            $data['media_url'] = '/storage/' . $mediaPath;
        }

        unset($data['media']);
        return $this->clientPackageItemRepo->update($clientPackageId, $id, $data);
    }

    public function destroy($clientPackageId, $id)
    {
        return $this->clientPackageItemRepo->destroy($clientPackageId, $id);
    }

    // public function accept($id)
    // {
    //     return $this->clientPackageItemRepo->accept($id);
    // }

    // public function decline($id)
    // {
    //     return $this->clientPackageItemRepo->decline($id);
    // }

    // public function edit($id)
    // {
    //     return $this->clientPackageItemRepo->edit($id);
    // }

    public function accept(int $id, array $data)
    {
        $item = ClientPackageItem::findOrFail($id);

        $allowed = PackageAllowedItem::where('package_item_id', $item->package_item_id)->first();

        $acceptedCount = ClientPackageItem::where('client_package_id', $item->client_package_id)
            ->where('item_type', $item->item_type)
            ->where('status', 'accepted')->count();

        if ($acceptedCount >= $allowed->max_count) {
            throw ValidationException::withMessages(['limit' => 'Max accepted items reached for this package.']);
        }

        $item->status = 'accepted';
        $item->save();

        $this->HistoryStatusChange($item, 'accepted', $data);
        $this->logUsage($item, 'accept');
        event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

        return $item;
    }

    public function edit(int $id, array $data)
    {
        $item = ClientPackageItem::findOrFail($id);

        $limit = $this->clientLimitRepo->getByPackageAndType($item->client_package_id, $item->item_type);
        if (!$limit || $limit->edit_limit <= 0) {
            throw ValidationException::withMessages(['edit' => 'Edit limit reached.']);
        }

        $item->status = 'edited';
        $item->save();

        $this->clientLimitRepo->decrementEdit($item->client_package_id, $item->item_type);
        $this->HistoryStatusChange($item, 'edited', $data);
        $this->logUsage($item, 'edit');
        event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

        return $item;
    }

    public function decline(int $id, array $data)
    {
        $item = ClientPackageItem::findOrFail($id);

        $limit = $this->clientLimitRepo->getByPackageAndType($item->client_package_id, $item->item_type);
        if (!$limit || $limit->decline_limit <= 0) {
            throw ValidationException::withMessages(['decline' => 'Decline limit reached.']);
        }

        $item->status = 'declined';
        $item->save();

        $this->clientLimitRepo->decrementDecline($item->client_package_id, $item->item_type);
        $this->HistoryStatusChange($item, 'declined', $data);
        $this->logUsage($item, 'decline');
        event(new ItemStatusUpdatedEvent($item->history()->latest()->first()));

        return $item;
    }

    protected function HistoryStatusChange(ClientPackageItem $item, string $status, array $data)
    {
        $mediaPath = null;

        if (isset($data['media'])) {
            $mediaPath = $data['media']->store('client_package_items', 'public');
        }

        ItemStatusHistory::create([
            'client_package_item_id' => $item->id,
            'status' => $status,
            'note' => $data['note'] ?? null,
            'media_path' => $mediaPath,
        ]);
    }

    protected function logUsage(ClientPackageItem $item, string $actionType)
    {
        ItemUsageLog::create([
            'client_package_item_id' => $item->id,
            'client_id' => $item->client_id,
            'action_type' => $actionType,
        ]);
    }
}
