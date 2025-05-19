<?php

namespace App\Repositories\PackageAllowedItem;

use App\Models\PackageAllowedItem;
use App\Repositories\PackageAllowedItem\PackageAllowedItemRepositoryInterface;

class PackageAllowedItemRepository implements PackageAllowedItemRepositoryInterface
{
    public function all()
    {
        return PackageAllowedItem::all();
    }

    public function find($id): PackageAllowedItem
    {
        return PackageAllowedItem::findOrFail($id);
    }

    public function create(array $data): PackageAllowedItem
    {
        return PackageAllowedItem::create($data);
    }

    public function update($id, array $data): PackageAllowedItem
    {
        $item = PackageAllowedItem::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function delete($id): bool
    {
        $item = PackageAllowedItem::findOrFail($id);
        return $item->delete();
    }
}
