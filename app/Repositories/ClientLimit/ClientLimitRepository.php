<?php

namespace App\Repositories;

use App\Models\ClientLimit;
use App\Repositories\Interfaces\ClientLimitRepositoryInterface;

class ClientLimitRepository implements ClientLimitRepositoryInterface
{
    public function getByClientPackageAndType($clientPackageId, $itemType)
    {
        return ClientLimit::where('client_package_id', $clientPackageId)
                          ->where('item_type', $itemType)
                          ->first();
    }

    public function decrementLimit($clientPackageId, $itemType, $field)
    {
        $limit = $this->getByClientPackageAndType($clientPackageId, $itemType);
        if ($limit && in_array($field, ['remaining_edits', 'remaining_declines'])) {
            $limit->decrement($field);
        }
        return $limit;
    }

    public function getRemainingLimits($clientPackageId): array
    {
        return ClientLimit::where('client_package_id', $clientPackageId)
                          ->get()
                          ->keyBy('item_type')
                          ->map(function ($limit) {
                              return [
                                  'edits' => $limit->remaining_edits,
                                  'declines' => $limit->remaining_declines,
                              ];
                          })->toArray();
    }
}
