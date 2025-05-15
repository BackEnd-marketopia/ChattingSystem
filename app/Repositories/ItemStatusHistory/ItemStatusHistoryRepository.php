<?php

namespace App\Repositories;

use App\Models\ItemStatusHistory;
use App\Repositories\Interfaces\ItemStatusHistoryRepositoryInterface;

class ItemStatusHistoryRepository implements ItemStatusHistoryRepositoryInterface
{
    public function create(array $data): ItemStatusHistory
    {
        return ItemStatusHistory::create($data);
    }

    public function find(int $id): ?ItemStatusHistory
    {
        return ItemStatusHistory::find($id);
    }

    public function update(int $id, array $data): bool
    {
        $item = ItemStatusHistory::findOrFail($id);
        return $item->update($data);
    }

    public function delete(int $id): bool
    {
        $item = ItemStatusHistory::findOrFail($id);
        return $item->delete();
    }

    public function getByItem(int $itemId): array
    {
        return ItemStatusHistory::where('client_package_item_id', $itemId)->get()->toArray();
    }
}
