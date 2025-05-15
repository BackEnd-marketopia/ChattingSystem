<?php

namespace App\Repositories\PackageItem;

interface PackageItemRepositoryInterface
{
    public function getByPackageId($packageId);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function find($id);
}
