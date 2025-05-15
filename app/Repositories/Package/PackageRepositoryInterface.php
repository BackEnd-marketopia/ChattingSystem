<?php

namespace App\Repositories\Package;

interface PackageRepositoryInterface
{
    //step 5
    // public function createPackage($clientId, $limits);
    // public function addItem($packageId, $data);
    // public function updateItemStatus($itemId, $status);
    // public function getClientPackageItems($clientId);

    public function getAll();
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
