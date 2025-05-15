<?php

namespace App\Services;

use App\Repositories\PackageItem\PackageItemRepositoryInterface;

class PackageItemService
{
    protected $repository;

    public function __construct(PackageItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getItemsForPackage($packageId)
    {
        return $this->repository->getByPackageId($packageId);
    }

    public function store(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }
}
