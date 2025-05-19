<?php

namespace App\Repositories\ClientLimit;

use App\Models\ClientLimit;
use App\Repositories\ClientLimit\ClientLimitRepositoryInterface;

class ClientLimitRepository implements ClientLimitRepositoryInterface
{
    // public function getByClientPackageAndType($clientPackageId, $itemType)
    // {
    //     return ClientLimit::where('client_package_id', $clientPackageId)
    //                       ->where('item_type', $itemType)
    //                       ->first();
    // }

    // public function decrementLimit($clientPackageId, $itemType, $field)
    // {
    //     $limit = $this->getByClientPackageAndType($clientPackageId, $itemType);
    //     if ($limit && in_array($field, ['remaining_edits', 'remaining_declines'])) {
    //         $limit->decrement($field);
    //     }
    //     return $limit;
    // }

    // public function getRemainingLimits($clientPackageId): array
    // {
    //     return ClientLimit::where('client_package_id', $clientPackageId)
    //                       ->get()
    //                       ->keyBy('item_type')
    //                       ->map(function ($limit) {
    //                           return [
    //                               'edits' => $limit->remaining_edits,
    //                               'declines' => $limit->remaining_declines,
    //                           ];
    //                       })->toArray();
    // }

    public function getAll(array $filters = [])
    {
        return ClientLimit::when(isset($filters['client_id']), fn($q) => $q->where('client_id', $filters['client_id']))
            ->when(isset($filters['client_package_id']), fn($q) => $q->where('client_package_id', $filters['client_package_id']))
            ->get();
    }

    public function create(array $data)
    {
        return ClientLimit::create($data);
    }

    public function update($id, array $data)
    {
        $limit = ClientLimit::findOrFail($id);
        $limit->update($data);
        return $limit;
    }

    public function delete($id)
    {
        $limit = ClientLimit::findOrFail($id);
        return $limit->delete();
    }



    public function getByPackageAndType($clientPackageId, $itemType)
    {
        return ClientLimit::where('client_package_id', $clientPackageId)
            ->where('item_type', $itemType)
            ->first();
    }

    public function decrementEdit($clientPackageId, $itemType)
    {
        $limit = $this->getByPackageAndType($clientPackageId, $itemType);
        if ($limit && $limit->edit_limit > 0) {
            $limit->decrement('edit_limit');
            return $limit;
        }
        return null;
    }

    public function decrementDecline($clientPackageId, $itemType)
    {
        $limit = $this->getByPackageAndType($clientPackageId, $itemType);
        if ($limit && $limit->decline_limit > 0) {
            $limit->decrement('decline_limit');
            return $limit;
        }
        return null;
    }
}
