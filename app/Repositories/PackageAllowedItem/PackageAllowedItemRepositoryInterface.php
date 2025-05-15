<?php

namespace App\Repositories\Interfaces;

use App\Models\PackageAllowedItem;

interface PackageAllowedItemRepositoryInterface
{
    public function all();
    public function find($id): PackageAllowedItem;
    public function create(array $data): PackageAllowedItem;
    public function update($id, array $data): PackageAllowedItem;
    public function delete($id): bool;
    public function getByPackage($packageId);
}