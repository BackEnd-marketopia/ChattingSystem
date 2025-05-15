<?php

namespace App\Repositories\PackageItem;

interface PackageItemUsageRepositoryInterface
{
    public function getClientPackage($clientId, $packageId);
    public function getLimit($clientPackageId, $itemType);
    public function countUsages($clientPackageId, $itemType, $itemId, $action);
    public function logUsage($clientPackageId, $itemType, $itemId, $action, $note = null);
    
}
