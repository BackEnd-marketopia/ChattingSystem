<?php


namespace App\Repositories;

use App\Models\ClientLimit;
use App\Models\ClientPackage;
use App\Models\ItemUsageLog;

class PackageItemUsageRepository
{
    public function getClientPackage($clientId, $packageId)
    {
        return ClientPackage::where('client_id', $clientId)
            ->where('package_id', $packageId)
            ->first();
    }

    public function getLimit($clientPackageId, $itemType)
    {
        return ClientLimit::where('client_package_id', $clientPackageId)
            ->where('item_type', $itemType)
            ->first();
    }

    public function countUsages($clientPackageId, $itemType, $itemId, $action)
    {
        return ItemUsageLog::where('client_package_id', $clientPackageId)
            ->where('item_type', $itemType)
            ->where('item_id', $itemId)
            ->where('action', $action)
            ->count();
    }

    public function logUsage($clientPackageId, $itemType, $itemId, $action, $note = null)
    {
        return ItemUsageLog::create([
            'client_package_id' => $clientPackageId,
            'item_type' => $itemType,
            'item_id' => $itemId,
            'action' => $action,
            'note' => $note,
        ]);
    }
}
