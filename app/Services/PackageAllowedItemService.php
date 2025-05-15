<?php

namespace App\Services;

use App\Repositories\Interfaces\PackageAllowedItemRepositoryInterface;

class PackageAllowedItemService
{
    protected $repo;

    public function __construct(PackageAllowedItemRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function all() { return $this->repo->all(); }
    public function find($id) { return $this->repo->find($id); }
    public function create(array $data) { return $this->repo->create($data); }
    public function update($id, array $data) { return $this->repo->update($id, $data); }
    public function delete($id) { return $this->repo->delete($id); }
    public function getByPackage($packageId) { return $this->repo->getByPackage($packageId); }
}