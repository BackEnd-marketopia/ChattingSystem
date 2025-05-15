<?php

namespace App\Repositories;

use App\Models\PackageAllowedItem;
use App\Repositories\Interfaces\PackageAllowedItemRepositoryInterface;

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

    public function getByPackage($packageId)
    {
        return PackageAllowedItem::where('package_id', $packageId)->get();
    }
}