<?php

namespace App\Repositories\Package;

interface PackageRepositoryInterface
{
    public function createPackage($clientId, $limits);
    public function addItem($packageId, $data);
    public function updateItemStatus($itemId, $status);
    public function getClientPackageItems($clientId);
}
