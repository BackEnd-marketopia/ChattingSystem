<?php

namespace App\Repositories\ItemStatusHistory;

use App\Models\ItemStatusHistory;

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
        return ItemStatusHistory::where('client_package_id', $itemId)->get()->toArray();
    }
}
