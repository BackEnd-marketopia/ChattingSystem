<?php

namespace App\Repositories\PackageItem;

use App\Models\PackageItem;
use App\Repositories\PackageItem\PackageItemRepositoryInterface;

class PackageItemRepository implements PackageItemRepositoryInterface
{
    public function getByPackageId($packageId)
    {
        return PackageItem::where('package_id', $packageId)->get();
    }

    public function create(array $data)
    {
        return PackageItem::create($data);
    }

    public function update($id, array $data)
    {
        $item = PackageItem::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        return PackageItem::destroy($id);
    }

    public function find($id)
    {
        return PackageItem::findOrFail($id);
    }
}
