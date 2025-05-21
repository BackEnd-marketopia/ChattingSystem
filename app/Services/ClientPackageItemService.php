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
use App\Models\PackageItem;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Repositories\ClientLimit\ClientLimitRepositoryInterface;
use Illuminate\Http\Request;

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


    public function accept(int $id, array $data)
    {
        $item = ClientPackageItem::findOrFail($id);
        $allowed = PackageAllowedItem::where('package_item_id', $item->package_item_id)->first();

        $acceptedCount = ItemStatusHistory::where('client_package_id', $item->id)
            ->where('item_id', $item->packageItem->type_id)
            ->where('status', 'accepted')
            ->count();
        // dd($acceptedCount);
        // dd($allowed->allowed_count);
        if ($acceptedCount >= $allowed->allowed_count) {
            // dd('das');
            return [
                'message' => 'Maximum accepted items reached for this package Item.',
                'item' => null
            ];
        }

        $item->status = 'accepted';
        $item->save();

        $data['item_id'] = $item->packageItem->type_id;

        $this->HistoryStatusChange($item, 'accepted', $data);
        $this->logUsage($item, 'accept');

        $chatMessage = new \App\Models\ChatMessage([
            'chat_id' => $item->clientPackage->chat_id,
            'sender_id' => Auth::id(),
            'message' => "Item of type {$item->item_type} has been accepted.",
            'file_path' => $item->media_url,
        ]);
        $chatMessage->save();
        event(new \App\Events\NewMessageEvent($chatMessage));

        return [
            'message' => 'Item accepted successfully.',
            'item' => $item
        ];
    }

    public function edit(int $id, array $data)
    {
        $item = ClientPackageItem::findOrFail($id);

        // dd($item);
        // $editCount = ItemStatusHistory::where('client_package_id', $item->id)
        //     ->where('item_id', $item->packageItem->type_id)
        //     ->where('status', 'edited')
        //     ->count();

        // dd($editCount);
        // $editCount = ItemStatusHistory::where('client_package_item_id', $item->id)
        //     ->where('status', 'edited')
        //     ->count();
        // dd($item->packageItem?->itemType->name);
        $limit = $this->clientLimitRepo->getByPackageAndType($item->client_package_id, $item->packageItem->itemType->name);
        if (!$limit || $limit->edit_limit <= 0) {
            return [
                'message' => 'Edit limit reached.',
                'item' => null
            ];
        }

        $item->status = 'edited';
        $item->save();

        $data['item_id'] = $item->packageItem->type_id;


        $this->clientLimitRepo->decrementEdit($item->client_package_id, $item->packageItem->itemType->name);
        $this->HistoryStatusChange($item, 'edited', $data);
        $this->logUsage($item, 'edit');

        $chatMessage = new \App\Models\ChatMessage([
            'chat_id' => $item->clientPackage->chat_id,
            'sender_id' => Auth::id(),
            'message' => "Item of type {$item->item_type} has been edited.",
            'file_path' => $item->media_url,
        ]);
        $chatMessage->save();
        event(new \App\Events\NewMessageEvent($chatMessage));

        return [
            'message' => 'Item edited successfully.',
            'item' => $item
        ];
    }

    public function decline(int $id, array $data)
    {
        $item = ClientPackageItem::findOrFail($id);

        // $declineCount = ItemStatusHistory::where('client_package_item_id', $item->id)
        //     ->where('status', 'declined')
        //     ->count();

        // $declineCount = ItemStatusHistory::where('client_package_id', $item->id)
        //     ->where('item_id', $item->packageItem->type_id)
        //     ->where('status', 'declined')
        //     ->count();

        $limit = $this->clientLimitRepo->getByPackageAndType($item->client_package_id, $item->packageItem->itemType->name);
        if (!$limit || $limit->decline_limit <= 0) {
            return [
                'message' => 'Decline limit reached.',
                'item' => null
            ];
        }

        $item->status = 'declined';
        $item->save();

        $data['item_id'] = $item->packageItem->type_id;

        $this->clientLimitRepo->decrementDecline($item->client_package_id, $item->packageItem->itemType->name);
        $this->HistoryStatusChange($item, 'declined', $data);
        $this->logUsage($item, 'decline');

        $chatMessage = new \App\Models\ChatMessage([
            'chat_id' => $item->client_package_id,
            'sender_id' => Auth::id(),
            'message' => "Item of type {$item->item_type} has been declined.",
            'file_path' => $item->media_url,
        ]);
        $chatMessage->save();
        event(new \App\Events\NewMessageEvent($chatMessage));

        return [
            'message' => 'Item declined successfully.',
            'item' => $item
        ];
    }

    protected function HistoryStatusChange($item, string $status, array $data)
    {
        $mediaPath = null;

        if (isset($data['media'])) {
            $mediaPath = $data['media']->store('client_package_items', 'public');
        }

        ItemStatusHistory::create([
            'client_package_id' => $item->client_package_id,
            'status' => $status,
            'item_id' => $data['item_id'],
            'note' => $data['note'] ?? null,
            'updated_by' => Auth::id(),
        ]);
    }

    protected function logUsage($item, string $actionType)
    {
        ItemUsageLog::create([
            'item_id' => $item->packageItem->type_id,
            'item_type' => $item->item_type,
            'client_package_id' => $item->client_package_id,
            'client_id' => Auth::id(),
            'action_type' => $actionType,
        ]);
    }
}
