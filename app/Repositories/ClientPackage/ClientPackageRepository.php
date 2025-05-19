<?php

namespace App\Repositories\ClientPackage;

use App\Models\ClientPackage;
use App\Models\ItemUsageLog;
use App\Models\ItemStatusHistory;


class ClientPackageRepository implements ClientPackageInterface
{
    public function logItemUsage($clientPackageId, $itemType, $itemId, $action, $userId)
    {
        return ItemUsageLog::create([
            'client_package_id' => $clientPackageId,
            'item_type' => $itemType,
            'item_id' => $itemId,
            'action' => $action,
            'performed_by' => $userId,
        ]);
    }

    public function changeItemStatus($clientPackageId, $itemType, $itemId, $status, $note = null, $userId = null)
    {
        return ItemStatusHistory::create([
            'client_package_id' => $clientPackageId,
            'item_type' => $itemType,
            'item_id' => $itemId,
            'status' => $status,
            'note' => $note,
            'updated_by' => $userId,
        ]);
    }


    public function all()
    {
        return ClientPackage::all();
    }

    public function find($id)
    {
        return ClientPackage::findOrFail($id);
    }

    public function create(array $data)
    {
        return ClientPackage::create($data);
    }

    public function update($id, array $data)
    {
        $package = ClientPackage::findOrFail($id);
        $package->update($data);
        return $package;
    }

    public function delete($id)
    {
        return ClientPackage::destroy($id);
    }
}
