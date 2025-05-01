<?php

use App\Models\Package;
use App\Models\PackageItem;

class PackageRepository implements PackageRepositoryInterface
{
    public function createPackage($clientId, $limits)
    {
        return Package::create([
            'client_id' => $clientId,
            'limits' => $limits
        ]);
    }

    public function addItem($packageId, $data)
    {
        return PackageItem::create([
            'package_id' => $packageId,
            'type' => $data['type'],
            'content_type' => $data['content_type'],
            'content_value' => $data['content_value'],
        ]);
    }

    public function updateItemStatus($itemId, $status)
    {
        $item = PackageItem::findOrFail($itemId);
        $item->update(['status' => $status]);
        return $item;
    }

    public function getClientPackageItems($clientId)
    {
        return PackageItem::whereHas('package', function ($q) use ($clientId) {
            $q->where('client_id', $clientId);
        })->get();
    }
}
