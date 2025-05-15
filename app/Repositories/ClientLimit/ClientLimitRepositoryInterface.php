<?php

namespace App\Repositories\Interfaces;

use App\Models\ClientLimit;

interface ClientLimitRepositoryInterface
{
    public function getByClientPackageAndType($clientPackageId, $itemType);
    public function decrementLimit($clientPackageId, $itemType, $field); // 'edit' or 'decline'
    public function getRemainingLimits($clientPackageId): array;
}
